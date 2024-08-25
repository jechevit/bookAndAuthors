<?php

namespace app\commands;

use app\core\entities\catalog\Author;
use app\core\entities\catalog\Book;
use app\core\forms\catalog\AuthorForm;
use app\core\forms\catalog\BookForm;
use app\core\services\catalog\AuthorService;
use app\core\services\catalog\BookService;
use Faker\Calculator\Ean;
use Faker\Provider\Base;
use Faker\Provider\Lorem;
use Faker\Provider\ru_RU\Person;
use Faker\Provider\ru_RU\Text;
use Yii;
use yii\console\Controller;

class FakeController extends Controller
{
    public function __construct(                      $id, $module,
                                private AuthorService $authorService,
                                private BookService $bookService,
                                                      $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionCreateBooks()
    {
        $generator = \Faker\Factory::create('ru_RU');
        $textFaker = new Text($generator);

        $authors = Author::find()->indexBy('id')
            ->limit(2000);

        $form = new BookForm();
        foreach ($authors->batch(50) as $batch) {
            foreach ($batch as $key => $author) {
                $data = [
                    'name' => $generator->realText(rand(14, 30)),
                    'description' => $textFaker->realText(rand(100, 200)),
                    'year' => $generator->year(),
                    'isbn' => $generator->isbn13(),
                ];

                $authors = [$author->id];
                if ($key % 3 === 0) {
                    $randomAuthor = $batch[array_rand($batch, 1)];
                    if ($randomAuthor->id !== $author->id) {
                        $authors[] = $randomAuthor->id;
                    }
                }
                $form->authors = $authors;
                if ($form->load($data, '') && $form->validate()) {
                    $this->bookService->create($form);
                }
                foreach ($form->authors as $authorId) {
                    $this->authorService->countAuthorBooks($authorId);
                }
                unset($data);
                unset($authors);

                gc_collect_cycles();
            }
        }
    }

    public function actionCreateAuthors(): void
    {
        $generator = \Faker\Factory::create('ru_RU');
        $faker = new Person($generator);
        for ($i = 0; $i < 10000; $i++) {

            $form = new AuthorForm();
            $data = [
                'name' => $faker->firstName(),
                'patronymic' => $faker->middleName(),
                'last_name' => $faker->lastName()
            ];

            if ($form->load($data, '') && $form->validate()) {
                $this->authorService->create($form);
            }
        }
    }
}
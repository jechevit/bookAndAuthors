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
//
        $textFaker = new Text($generator);

        $authors = Author::find()->indexBy('id')
            ->limit(200)
        ;

        $form = new BookForm();
        foreach ($authors->batch(50) as $batch) {
//            $form = new BookForm();
            echo 'get batch - ' . round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
            echo '-------------------'. PHP_EOL;
            foreach ($batch as $key => $author) {
//                $generator = \Faker\Factory::create('ru_RU');

//                $textFaker = new Text($generator);
                $generate1 = round(memory_get_usage() / 1024 / 1024, 2);
                $data = [
                    'name' => $generator->realText(rand(14, 30)),
                    'description' => $textFaker->realText(rand(100, 200)),
                    'year' => $generator->year(),
                    'isbn' => $generator->isbn13(),
                ];

                $generate = round(memory_get_usage() / 1024 / 1024, 2);
//                echo 'generate data - ' .  round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
                $authors = [$author];
                if ($key % 3 === 0) {
                    $randomAuthor = $batch[array_rand($batch, 1)];
                    if ($randomAuthor->id !== $author->id) {
                        $authors[] = $randomAuthor;
                    }
                }
                $random = round(memory_get_usage() / 1024 / 1024, 2);
//                echo 'random actions - ' .  round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
                if ($form->load($data, '')
//                    && $form->validate()
                ) {
                    $loadAndValidate = round(memory_get_usage() / 1024 / 1024, 2);
//                    echo 'load and validate - ' .   round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
                    $this->bookService->create($form, $authors);
                    $create = round(memory_get_usage() / 1024 / 1024, 2);

//                    echo 'create - ' .   round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
                }

                echo 'generate1 data - ' .  $generate1 . ' MB;'.
                    'generate data - ' .  $generate . ' MB;'
                    . ' random actions - ' . $random  . ' MB;'
                    . ' load and validate -  ' . ($loadAndValidate ?? '-')  . ' MB;'
                    .' create - ' .   ($create ?? '-') . ' MB' . PHP_EOL;
                echo '#######################'. PHP_EOL;
                unset($data);
                unset($authors);

                gc_collect_cycles();
//                unset($textFaker);
//                unset($generator);
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
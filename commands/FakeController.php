<?php

namespace app\commands;

use app\core\forms\catalog\AuthorForm;
use app\core\services\catalog\AuthorService;
use Faker\Provider\ru_RU\Person;
use yii\console\Controller;

class FakeController extends Controller
{
    public function __construct(                      $id, $module,
                                private AuthorService $authorService,
                                                      $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionCreateBooks()
    {

    }

    public function actionCreateAuthors()
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
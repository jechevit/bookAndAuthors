<?php

namespace app\controllers\redact;

use app\core\forms\catalog\AuthorForm;
use app\core\repositories\catalog\AuthorRepository;
use yii\filters\AccessControl;
use yii\web\Controller;

class AuthorController extends Controller
{
    public function __construct($id, $module,
                                private readonly AuthorRepository $repository,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionView(int $id)
    {
        $author = $this->repository->find($id);
        $model = new AuthorForm($author);

        return $this->render('view', [
            'author' => $author,
            'model' => $model,
        ]);
    }
}
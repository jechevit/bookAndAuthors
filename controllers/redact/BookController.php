<?php

namespace app\controllers\redact;

use core\searchForms\redact\BookSearchForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class BookController extends Controller
{
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

    }
}
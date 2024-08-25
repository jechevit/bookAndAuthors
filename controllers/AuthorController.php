<?php

namespace app\controllers;

use core\searchForms\redact\AuthorSearchForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class AuthorController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new AuthorSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
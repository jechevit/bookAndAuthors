<?php

namespace app\controllers;

use core\searchForms\redact\BookSearchForm;
use Yii;
use yii\web\Controller;

class BookController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new BookSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
<?php

namespace app\controllers;

use app\core\searchForms\AuthorTopSearchForm;
use Yii;
use yii\web\Controller;

class ReportController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionIndex(): string
    {
        $searchModel = new AuthorTopSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
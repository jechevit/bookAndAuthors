<?php

use app\core\entities\catalog\Author;
use core\searchForms\redact\AuthorSearchForm;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var AuthorSearchForm $searchModel
 * @var ActiveDataProvider $dataProvider
 */

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?= GridView::widget([
            'pager' => [
                'linkOptions'                   => ['class' => 'page-link'],
                'linkContainerOptions'          => ['class' => 'page-item'],
                'disabledListItemSubTagOptions' => ['tag' => 'a', 'href' => '#', 'class' => "page-link"],
            ],
            'layout' => "{summary}\n{items}\n{pager}",
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'label' => 'last_name',
                    'filter' => Html::input('text', 'last_name', $searchModel->last_name, ['class' => 'form-control']),
                    'value' => function (Author $author) {
                        return $author->getShortFullName();
                    },
                ],
                [
                    'label' => 'Books counter',
                    'value' => function (Author $author) {
                        return $author->books_count;
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{view}',
                    'visibleButtons' => [
                            'view' => !Yii::$app->user->isGuest
                    ]
                ]
            ]
        ]) ?>
    </div>
</div>

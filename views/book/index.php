<?php

use app\core\entities\catalog\Book;
use core\searchForms\redact\BookSearchForm;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var BookSearchForm $searchModel
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
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'label' => 'Full Name',
                    'value' => function (Book $book) {
                        return $book->name;
                    },
                ],
                [
                    'label' => 'Authors',
                    'value' => function (Book $book) {
                        return implode(', ', $book->getAuthorData());
                    },
                ],
                [
                    'label' => 'Created at',
                    'value' => function (Book $book) {
                        return Yii::$app->formatter->asDate($book->created_at, 'php:Y-m-d H:i:s');
                    },
                ],
                [
                    'label' => 'Updated at',
                    'value' => function (Book $book) {
                        if ($book->updated_at) {
                            return Yii::$app->formatter->asDate($book->updated_at, 'php:Y-m-d H:i:s');
                        }
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'buttons' => [
                        'view' => function ($url, Book $book) {
                            $url = Url::to(['redact/book/view', 'id' => $book->id]);
                            return Html::a('Redact', $url, []);
                        }
                    ],
                    'template' => '{view}',
                    'visibleButtons' => [
                        'view' => !Yii::$app->user->isGuest
                    ]
                ]
            ]
        ]) ?>
    </div>

</div>

<?php

use app\core\entities\catalog\Author;
use app\core\entities\catalog\Book;
use app\core\searchForms\AuthorTopSearchForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var AuthorTopSearchForm $searchModel
 * @var ActiveDataProvider $dataProvider
 */

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'label' => 'Full Name',
                    'value' => function (Author $author) {
                        return $author->getShortFullName();
                    },
                ],
                'books_per_year',
                [
                    'attribute' => 'books',
                    'label' => 'Qnt all authors books',
                    'value' => function (Author $author) {
                        return count($author->books);
                    },
                ],
                [
                    'attribute' => 'year',
                    'filter' => Html::dropDownList('year', $searchModel->year, $searchModel::getAllYears(), [
                        'class' => 'form-control',
                    ]),
                    'value' => function (Author $author) use ($searchModel)  {
                        $bookFilteredByYear = array_filter($author->books, function (Book $book) use ($searchModel) {
                            return $book->year == $searchModel->year;
                        });
                        return implode(', ', array_map(function (Book $book) {
                            return "{$book->name} ($book->year)";
                        }, $bookFilteredByYear));
                    },
                ],

            ]
        ]) ?>
    </div>

</div>

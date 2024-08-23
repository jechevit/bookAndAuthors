<?php

use app\core\entities\catalog\Author;
use app\core\entities\catalog\Book;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\widgets\ListView;

/**
 * @var View $this
 * @var Book[] $lastBooks
 * @var Author[] $lastAuthors
 */


$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

    </div>

    <div class="body-content">

        <div class="row">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Isbn</th>
                    <th scope="col">Year</th>
                    <th scope="col">Authors</th>
                    <th scope="col">Date create</th>
                </tr>
                </thead>
                <tbody>
                <?= ListView::widget([
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => $lastBooks,
                    ]),
                    'summary' => 'Last created books',
                    'itemView' => '_book_view',
                ]) ?>

                </tbody>

            </table>
        </div>
        <div class="row">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Qnt books</th>
                    <th scope="col">Date create</th>
                </tr>
                </thead>
                <tbody>
                <?= ListView::widget([
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => $lastAuthors,
                    ]),
                    'summary' => 'Last created authors',
                    'itemView' => '_author_view',
                ]) ?>

                </tbody>

            </table>


        </div>

    </div>
</div>

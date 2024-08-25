<?php

use app\assets\BookAsset;
use app\core\entities\catalog\Book;
use app\core\forms\catalog\BookForm;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 * @var Book | null $book
 * @var BookForm $model
 * @var array $authors
 */

BookAsset::register($this);

$action = Url::to(['ajax/book/update']);
$validationAction = Url::to(['/ajax/book/validate']);
if ($book) {
    $action = Url::to(['ajax/book/update', 'id' => $book->id]);
    $validationAction = Url::to(['/ajax/book/validate', 'id' => $book->id]);
}
$this->title = "Edit #{$book->id} {$book->name}";
?>
<div class="container">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Book list', 'url' => '/book'
        ],
        'links' => [
            ['label' => $this->title],
        ]
    ]) ?>

    <h4><?= $this->title ?></h4>
    <?php $form = ActiveForm::begin([
        'id' => 'book-form',
        'action' => $action,
        'options' => ['class' => 'content', 'enctype' => 'multipart/form-data'],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => $validationAction,
        'fieldConfig' => [
            'errorOptions' => [
                'encode' => false,
                'class' => 'invalid-feedback'
            ]
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['class' => 'form-control'])->label('Название') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'year')->textInput(['class' => 'form-control']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'authors')->widget(Select2::class, [
                'data' => $authors,
                'options' => ['multiple' => true, 'placeholder' => 'Search for a author ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => '/ajax/book/search-authors',
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea([
                'class' => 'form-control',
                'rows' => 4,
            ]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<?php

use app\assets\AuthorAsset;
use app\core\entities\catalog\Author;
use app\core\forms\catalog\AuthorForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var Author | null $author
 * @var AuthorForm $model
 * @var array $authors
 */

AuthorAsset::register($this);
$action = Url::to(['ajax/author/update']);
$validationAction = Url::to(['/ajax/author/validate']);
if ($author) {
    $action = Url::to(['ajax/author/update', 'id' => $author->id]);
    $validationAction = Url::to(['/ajax/author/validate', 'id' => $author->id]);
}
$this->title = "Edit #{$author->id} {$author->name}";
?>
<div class="container">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Author list', 'url' => '/author'
        ],
        'links' => [
            ['label' => $this->title],
        ]
    ]) ?>

    <h4><?= $this->title ?></h4>
    <?php $form = ActiveForm::begin([
        'id' => 'author-form',
        'action' => $action,
        'options' => ['class' => 'content', 'enctype' => 'multipart/form-data'],
        'enableAjaxValidation' => true,
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
            <?= $form->field($model, 'last_name')->textInput(['class' => 'form-control']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'patronymic')->textInput(['class' => 'form-control']) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::button('Remove', [
            'class' => 'btn btn-danger author-remove',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


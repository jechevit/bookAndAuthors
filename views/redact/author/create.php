<?php

use app\assets\AuthorAsset;
use app\core\forms\catalog\AuthorForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var AuthorForm $model
 */

AuthorAsset::register($this);

$action = Url::to(['ajax/author/create']);
$validationAction = Url::to(['/ajax/author/validate']);
$this->title = "Create author";
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


    <?= $this->render('_form', [
        'form' => $form,
        'model' => $model,
    ]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


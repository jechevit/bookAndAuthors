<?php


use app\core\forms\catalog\AuthorForm;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

/**
 * @var View $this
 * @var AuthorForm $model
 * @var ActiveForm $form
 */

?>

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


<?php

use app\core\entities\User;
use yii\helpers\Html;
use yii\web\View;

/* @var View $this */
/* @var User $user */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to confirm your email:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>

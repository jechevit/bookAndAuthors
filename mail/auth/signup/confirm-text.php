<?php


use app\core\entities\User;
use yii\web\View;

/* @var View $this */
/* @var User $user */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/confirm', 'token' => $user->email_confirm_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to confirm your email:

<?= $confirmLink ?>

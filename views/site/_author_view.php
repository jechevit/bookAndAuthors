<?php

use app\core\entities\catalog\Author;
use yii\web\View;

/**
 * @var View $this
 * @var Author $model
 */

?>

<tr>
    <th scope="row"><?= $model->id ?></th>
    <td><?= $model->name ?></td>
    <td><?= count($model->books) ?></td>
    <td><?= Yii::$app->formatter->asDatetime($model->created_at, "php:Y-m-d H:i") ?></td>
</tr>
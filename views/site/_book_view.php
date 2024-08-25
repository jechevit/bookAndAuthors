<?php

use app\core\entities\catalog\Book;
use yii\web\View;

/**
 * @var View $this
 * @var Book $model
 */

?>

<tr>
    <th scope="row"><?= $model->id ?></th>
    <td><?= $model->name ?></td>
    <td><?= $model->isbn ?></td>
    <td><?= $model->year ?></td>
    <td><?= implode(', ', $model->getAuthorData()) ?></td>
    <td><?= Yii::$app->formatter->asDatetime($model->created_at, "php:Y-m-d H:i") ?></td>
</tr>
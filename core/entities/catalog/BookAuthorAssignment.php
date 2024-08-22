<?php

namespace app\core\entities\catalog;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $book_id
 * @property int $author_id
 *
 */
class BookAuthorAssignment extends ActiveRecord
{
    public static function create(int $bookId, int $authorId): self
    {
        $model = new self();
        $model->book_id = $bookId;
        $model->author_id = $authorId;

        return $model;
    }

    public static function tableName(): string
    {
        return '{{%book_author_assignments}}';
    }
}
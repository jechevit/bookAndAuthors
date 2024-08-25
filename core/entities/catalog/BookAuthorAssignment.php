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
    public static function create(int $authorId): self
    {
        $model = new self();
        $model->author_id = $authorId;

        return $model;
    }

    public static function tableName(): string
    {
        return '{{%book_author_assignments}}';
    }

    public function isEqualAuthorId(int $id): bool
    {
        return $this->author_id == $id;
    }
}
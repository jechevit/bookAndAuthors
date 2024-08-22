<?php

namespace app\core\entities\catalog;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * 2. Авторы - ФИО.
 * @property int $id
 * @property string $name
 * @property string $patronymic
 * @property string $last_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Book[] $books
 * @property BookAuthorAssignment[] $bookAssignments
 */
class Author extends ActiveRecord
{
    /**
     * @param string $name
     * @param string $patronymic
     * @param string $lastName
     * @return Author
     */
    public static function create(string $name, string $patronymic, string $lastName): Author
    {
        $model = new self();
        $model->name = $name;
        $model->patronymic = $patronymic;
        $model->last_name = $lastName;

        return $model;
    }

    public static function tableName(): string
    {
        return "{{%authors}}";
    }

    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->via('bookAssignments');
    }

    public function getBookAssignments(): ActiveQuery
    {
        return $this->hasMany(BookAuthorAssignment::class, ['author_id' => 'id']);
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}
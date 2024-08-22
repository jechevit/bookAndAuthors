<?php

namespace app\core\entities\catalog;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * 1. Книга - название, год выпуска, описание, isbn, фото главной страницы.
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string $description
 * @property int $isbn
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Author[] $authors
 * @property BookAuthorAssignment[] $authorAssignments
 */
class Book extends ActiveRecord
{
    /**
     * @param string $name
     * @param string $description
     * @param int $year
     * @param int $isbn
     * @return self
     */
    public static function create(string $name, string $description, int $year, int $isbn): self
    {
        $model = new self();
        $model->name = $name;
        $model->description = $description;
        $model->year = $year;
        $model->isbn = $isbn;

        return $model;
    }

    public static function tableName(): string
    {
        return '{{%books}}';
    }

    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->via('authorAssignments');
    }

    public function getAuthorAssignments(): ActiveQuery
    {
        return $this->hasMany(BookAuthorAssignment::class, ['book_id' => 'id']);
    }

    public function behaviors(): array
    {
        return [
//            [
//                'class' => SaveRelationsBehavior::className(),
//                'relations' => ['networks', 'wishlistItems'],
//            ],
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
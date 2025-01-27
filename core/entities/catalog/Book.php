<?php

namespace app\core\entities\catalog;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * 1. Книга - название, год выпуска, описание, isbn, фото главной страницы.
 *
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string $description
 * @property string $photo
 * @property int $isbn
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Author[] $authors
 * @property BookAuthorAssignment[] $authorAssignments
 *
 * @mixin ImageUploadBehavior
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

    /**
     * @param string $name
     * @param string $description
     * @param int $year
     * @param int $isbn
     * @return void
     */
    public function edit(string $name, string $description, int $year, int $isbn): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->year = $year;
        $this->isbn = $isbn;
    }

    /**
     * @param Author $author
     * @return void
     */
    public function assignAuthor(Author $author): void
    {
        $authorAssignments = $this->authorAssignments;
        foreach ($authorAssignments as $authorAssignment) {
            if ($authorAssignment->isEqualAuthorId($author->id)) {
                return;
            }
        }
        $authorAssignments[] = BookAuthorAssignment::create($author->id);
        $this->authorAssignments = $authorAssignments;
    }

    public function revokeAuthor(int $author_id): void
    {
        $authorAssignments = $this->authorAssignments;
        foreach ($authorAssignments as $key => $authorAssignment) {
            if ($authorAssignment->isEqualAuthorId($author_id)) {
                unset($authorAssignments[$key]);
            }
        }
        $this->authorAssignments = $authorAssignments;
    }

    /** @return string[] */
    public function getAuthorData(): array
    {
        return array_map(function (Author $author) {
            return $author->getShortFullName() ;
        }, $this->authors);
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
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'authorAssignments',
                ],
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'filePath' => '@staticRoot/origin/books/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/books/[[id]].[[extension]]',
            ],
        ];
    }

    public function setPhoto(UploadedFile $photo)
    {
        $this->photo = $photo;
    }
}
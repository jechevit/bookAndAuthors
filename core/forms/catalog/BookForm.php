<?php

namespace app\core\forms\catalog;

use app\core\entities\catalog\Book;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class BookForm extends Model
{
    /** @var string|null */
    public  $name = null;
    /** @var string|null */
    public  $description = null;
    /** @var int|null */
    public  $year = null;
    /** @var int|null */
    public  $isbn = null;
    /** @var int[]|null */
    public  $authors;
    public $photo;

    public function __construct(Book $book = null, $config = [])
    {
        if ($book) {
            $this->name = $book->name;
            $this->description = $book->description;
            $this->year = $book->year;
            $this->isbn = $book->isbn;

            if (!empty($book->authors)) {
                $this->authors = ArrayHelper::getColumn($book->authors, 'id');

            }
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'description', 'year', 'isbn', 'authors',
//                'photo'
            ], 'required'],
            [['name'], 'string', 'length' => [10, 250]],
            [['description'], 'string', 'length' => [10, 1250]],
            [['year'], 'number',  'min' => 1900, 'max' => date('Y')],
            [['year'], 'date', 'format' => 'Y'],
            [['authors'], 'validateAuthors'],
            [['photo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function validateAuthors($attribute): void
    {
        if (!empty($this->authors) && count($this->authors) > 2) {
            $this->addError($attribute, 'Количество авторов не может быть больше 2');
        }
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }
        return false;
    }
}
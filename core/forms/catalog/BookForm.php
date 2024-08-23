<?php

namespace app\core\forms\catalog;

use app\core\entities\catalog\Book;
use yii\base\Model;

class BookForm extends Model
{
    public string | null $name = null;
    public string | null $description = null;
    public int | null $year = null;
    public int | null $isbn = null;

    public function __construct(Book $book = null, $config = [])
    {
        if ($book) {
            $this->name = $book->name;
            $this->description = $book->description;
            $this->year = $book->year;
            $this->isbn = $book->isbn;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'description', 'year', 'isbn'], 'required'],
        ];
    }
}
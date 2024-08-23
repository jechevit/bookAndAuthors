<?php

namespace app\core\repositories\catalog;

use app\core\entities\catalog\Book;
use app\core\exceptions\NotFoundException;
use app\core\exceptions\SaveErrorException;
use yii\db\ActiveRecord;

class BookRepository
{
    public function save(Book $model): void
    {
        if (!$model->save(false)) {
            throw new SaveErrorException('Saving error.');
        }
    }

    public function remove(Book $model): void
    {
        if (!$model->delete()) {
            throw new SaveErrorException('Removing error.');
        }
    }

    public function getLastBooks(int $limit = 10)
    {
        return Book::find()
            ->limit($limit)
            ->with('authors')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }

    /**
     * @param int $id
     * @return ActiveRecord|Book
     */
    public function find(int $id): ActiveRecord|Book
    {
        $book = Book::find()->andWhere(['id' => $id])->limit(1)->one();
        if (!$book) {
            throw new NotFoundException('Book not found.');
        }
        return $book;
    }
}
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
     * @return Book
     */
    public function find(int $id): Book
    {
        $book = $this->get($id);
        if (!$book) {
            throw new NotFoundException('Book not found.');
        }
        return $book;
    }

    public function get(int $id): Book|null
    {
        return Book::find()->andWhere(['id' => $id])->limit(1)->one();
    }
}
<?php

namespace app\core\repositories\catalog;

use app\core\entities\catalog\Book;
use app\core\exceptions\SaveErrorException;

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
}
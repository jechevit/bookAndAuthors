<?php

namespace app\core\repositories\catalog;

use app\core\entities\catalog\Author;
use app\core\exceptions\NotFoundException;
use app\core\exceptions\SaveErrorException;

class AuthorRepository
{
    public function save(Author $model): void
    {
        if (!$model->save()) {
            throw new SaveErrorException('Saving error.');
        }
    }

    public function remove(Author $model): void
    {
        if (!$model->delete()) {
            throw new SaveErrorException('Removing error.');
        }
    }

    /**
     * @param int $limit
     * @return array | Author[]
     */
    public function getLastAuthors(int $limit = 10): array
    {
        return Author::find()
            ->limit($limit)
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }

    /**
     * @param int $id
     * @return Author
     */
    public function find(int $id): Author
    {
        $author = $this->get($id);
        if (!$author) {
            throw new NotFoundException('Author not found.');
        }
        return $author;
    }

    public function get(int $id): Author|null
    {
        return Author::find()->andWhere(['id' => $id])->limit(1)->one();
    }

}
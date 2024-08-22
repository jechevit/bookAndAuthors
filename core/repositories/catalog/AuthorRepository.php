<?php

namespace app\core\repositories\catalog;

use app\core\entities\catalog\Author;
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

}
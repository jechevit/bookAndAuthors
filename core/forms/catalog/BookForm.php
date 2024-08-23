<?php

namespace app\core\forms\catalog;

use yii\base\Model;

class BookForm extends Model
{
    public string | null $name = null;
    public string | null $description = null;
    public int | null $year = null;
    public int | null $isbn = null;

    public function rules(): array
    {
        return [
            [['name', 'description', 'year', 'isbn'], 'required'],
        ];
    }
}
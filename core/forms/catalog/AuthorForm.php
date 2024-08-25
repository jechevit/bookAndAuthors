<?php

namespace app\core\forms\catalog;

use app\core\entities\catalog\Author;
use yii\base\Model;

class AuthorForm extends Model
{
    public string $name = '';
    public string $last_name = '';
    public string $patronymic = '';

    public function __construct(Author $author = null, $config = [])
    {
        if ($author) {
            $this->name = $author->name;
            $this->last_name = $author->last_name;
            $this->patronymic = $author->patronymic;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'last_name', 'patronymic'], 'required'],
            [['name', 'last_name', 'patronymic'], 'string'],
        ];
    }
}
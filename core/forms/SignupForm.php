<?php

namespace app\core\forms;

use app\models\User;
use yii\base\Model;

class SignupForm extends Model
{
    public string | null $username = '';
    public string | null  $email = '';
    public string | null  $phone = '';
    public string | null  $password = '';

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['phone', 'required'],
            ['phone', 'integer'],
        ];
    }
}

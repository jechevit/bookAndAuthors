<?php

namespace app\core\services\auth;

use app\core\forms\LoginForm;
use app\core\repositories\UserRepository;
use app\models\User;

class AuthService
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password.');
        }
        return $user;
    }
}
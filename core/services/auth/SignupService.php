<?php

namespace app\core\services\auth;

use app\core\forms\SignupForm;
use app\core\services\TransactionManager;
use app\models\User;
use app\core\repositories\UserRepository;

class SignupService
{
    private UserRepository $userRepository;
    private TransactionManager $transactionManager;

    public function __construct(
        UserRepository $userRepository,
        TransactionManager $transactionManager,
    )
    {
        $this->userRepository = $userRepository;
        $this->transactionManager = $transactionManager;
    }

    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->phone,
            $form->password
        );
        $this->transactionManager->wrap(function () use ($user) {
            $this->userRepository->save($user);
        });

        $sent = \Yii::$app->mailer
            ->compose(
                ['html' => 'auth/signup/confirm-html', 'text' => 'auth/signup/confirm-text'],
                ['user' => $user]
            )
            ->setTo($user->email)
            ->setSubject('Signup confirm')
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Email sending error.');
        }
    }

    public function confirm($token): void
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirm token.');
        }
        $user = $this->userRepository->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->userRepository->save($user);
    }
}
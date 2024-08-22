<?php

namespace app\core\auth;

use app\core\entities\User;
use app\core\readModels\UserReadRepository;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\di\NotInstantiableException;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface
{
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public static function findIdentity($id): Identity|IdentityInterface|null
    {
        $user = self::getRepository()->findActiveById($id);
        return $user ? new self($user): null;
    }

    /**
     * @param $token
     * @param $type
     * @return mixed
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): mixed
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @return UserReadRepository
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    private static function getRepository(): UserReadRepository
    {
        return \Yii::$container->get(UserReadRepository::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->user->id;
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }
}
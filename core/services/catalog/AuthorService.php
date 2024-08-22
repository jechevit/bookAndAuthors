<?php

namespace app\core\services\catalog;

use app\core\forms\catalog\AuthorForm;
use app\core\services\TransactionManager;
use app\core\entities\catalog\Author;
use app\core\repositories\catalog\AuthorRepository;

class AuthorService
{
    private TransactionManager $transactionManager;
    private AuthorRepository $repository;

    public function __construct(
        AuthorRepository $repository,
        TransactionManager $transactionManager,
    )
    {
        $this->transactionManager = $transactionManager;
        $this->repository = $repository;
    }

    public function create(AuthorForm $form): void
    {
        $model = Author::create(
            $form->name,
            $form->patronymic,
            $form->last_name
        );
        $this->repository->save($model);
    }
}
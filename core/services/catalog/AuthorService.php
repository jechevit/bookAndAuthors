<?php

namespace app\core\services\catalog;

use app\core\forms\catalog\AuthorForm;
use app\core\services\TransactionManager;
use app\core\entities\catalog\Author;
use app\core\repositories\catalog\AuthorRepository;

class AuthorService
{
    public function __construct(
        private readonly AuthorRepository $repository,
        private readonly TransactionManager $transactionManager,
    ) {}

    /**
     * @param AuthorForm $form
     * @return Author|null
     * @throws \Throwable
     */
    public function create(AuthorForm $form):? Author
    {
        return $this->transactionManager->wrap(function () use ($form) {
            $model = Author::create(
                $form->name,
                $form->patronymic,
                $form->last_name
            );
            $this->repository->save($model);
            return $model;
        });
    }

    public function countAuthorBooks(mixed $authorId): void
    {
        $author = $this->repository->get($authorId);
        if ($author) {
            $author->countBooks();
            $this->repository->save($author);
        }
    }

    public function update(?Author $author, AuthorForm $model)
    {
        $this->transactionManager->wrap(function () use ($author, $model) {
            $author->edit(
                $model->name,
                $model->patronymic,
                $model->last_name
            );
            $this->repository->save($author);
        });
    }
}
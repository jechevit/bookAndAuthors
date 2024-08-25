<?php

namespace app\core\services\catalog;

use app\core\entities\catalog\Book;
use app\core\forms\catalog\BookForm;
use app\core\repositories\catalog\AuthorRepository;
use app\core\repositories\catalog\BookRepository;
use app\core\services\TransactionManager;
use yii\helpers\ArrayHelper;

class BookService
{
    public function __construct(
        private readonly BookRepository   $bookRepository,
        private readonly AuthorService $authorService,
        private readonly AuthorRepository $authorRepository,
        private readonly TransactionManager $manager
    ) {}

    /**
     * @param BookForm $form
     * @return void
     * @throws \Throwable
     */
    public function create(BookForm $form): void
    {
        $this->manager->wrap(function () use ($form) {
            $book = Book::create(
                $form->name,
                $form->description,
                $form->year,
                $form->isbn
            );

            if ($form->photo) {
                $book->setPhoto($form->photo);
            }

            foreach ($form->authors as $id) {
                $author = $this->authorRepository->get($id);
                $book->assignAuthor($author);
            }
            $this->bookRepository->save($book);
            $this->updateAuthorData(ArrayHelper::getColumn($book->authorAssignments, 'author_id'));
        });
    }

    /**
     * @param Book $book
     * @param BookForm $model
     * @return void
     * @throws \Throwable
     */
    public function update(Book $book, BookForm $model): void
    {
        $this->manager->wrap(function () use ($book, $model) {
            $book->edit(
                $model->name,
                $model->description,
                $model->year,
                $model->isbn
            );

            if ($model->photo) {
                $book->setPhoto($model->photo);
            }

            $authors = $book->authorAssignments;
            $authorIds = [];
            foreach ($authors as $author) {
                if (!in_array($author->author_id, $model->authors)) {
                    $book->revokeAuthor($author->author_id);
                    $authorIds[] = $author->author_id;
                }
            }

            foreach ($model->authors as $id) {
                $author = $this->authorRepository->get($id);
                $book->assignAuthor($author);
            }
            $this->bookRepository->save($book);
            $authorIds = array_unique(array_merge($authorIds, ArrayHelper::getColumn($book->authorAssignments, 'author_id')));
            $this->updateAuthorData($authorIds);
        });
    }

    /**
     * @param int[] $authorIds
     * @return void
     */
    private function updateAuthorData(array $authorIds): void
    {
        foreach ($authorIds as $authorId) {
            $this->authorService->countAuthorBooks($authorId);
        }
    }

    public function remove(?Book $book): void
    {
        $authorIds = array_unique(ArrayHelper::getColumn($book->authorAssignments, 'author_id'));
        $book->authorAssignments = [];
        $this->bookRepository->save($book);
        $this->bookRepository->remove($book);
        $this->updateAuthorData($authorIds);
    }
}
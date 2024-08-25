<?php

namespace app\core\services\catalog;

use app\core\entities\catalog\Book;
use app\core\forms\catalog\BookForm;
use app\core\repositories\catalog\AuthorRepository;
use app\core\repositories\catalog\BookRepository;
use app\core\services\TransactionManager;

class BookService
{
    public function __construct(
        private readonly BookRepository   $bookRepository,
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

            foreach ($form->authors as $id) {
                $author = $this->authorRepository->get($id);
                $book->assignAuthor($author);
            }
            $this->bookRepository->save($book);
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

            $authors = $book->authorAssignments;
            foreach ($authors as $author) {
                if (!in_array($author->author_id, $model->authors)) {
                    $book->revokeAuthor($author->author_id);
                }
            }

            foreach ($model->authors as $id) {
                $author = $this->authorRepository->get($id);
                $book->assignAuthor($author);
            }
            $this->bookRepository->save($book);
        });
    }
}
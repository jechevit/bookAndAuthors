<?php

namespace app\core\services\catalog;

use app\core\entities\catalog\Author;
use app\core\entities\catalog\Book;
use app\core\forms\catalog\BookForm;
use app\core\repositories\catalog\BookRepository;
use app\core\services\TransactionManager;

class BookService
{
    public function __construct(
        private BookRepository $bookRepository,
        private TransactionManager $manager
    ) {}

    /**
     * @param array | Author[] $authors
     * @param BookForm $form
     * @return void
     * @throws \Throwable
     */
    public function create(BookForm $form,array $authors = []): void
    {

        $this->manager->wrap(function () use ($form, $authors) {
            $book = Book::create(
                $form->name,
                $form->description,
                $form->year,
                $form->isbn
            );
            $book->addAuthor($authors);
            $this->bookRepository->save($book);
        });



    }

    public function update(Book $book, BookForm $model)
    {
        $this->manager->wrap(function () use ($book, $model) {
            $book->edit(
                $model->name,
                $model->description,
                $model->year,
                $model->isbn
            );
//            $book->addAuthor($authors);
            $this->bookRepository->save($book);
        });
    }


}
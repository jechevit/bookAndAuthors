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
            $generate = round(memory_get_usage() / 1024 / 1024, 2);
            $book->addAuthor($authors);
            $random = round(memory_get_usage() / 1024 / 1024, 2);
            $this->bookRepository->save($book);
            $save = round(memory_get_usage() / 1024 / 1024, 2);

            $gc_collect_cycles = round(memory_get_usage() / 1024 / 1024, 2);

            echo 'create book - ' .  $generate . ' MB;'
                . ' add authors - ' . $random  . ' MB;'
                . ' save -  ' . $save  . ' MB;'
                . ' cleaning- ' . $gc_collect_cycles  . ' MB;'
                . PHP_EOL;
        });



    }


}
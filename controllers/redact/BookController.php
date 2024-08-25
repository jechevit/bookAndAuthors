<?php

namespace app\controllers\redact;

use app\core\entities\catalog\Author;
use app\core\forms\catalog\BookForm;
use app\core\repositories\catalog\BookRepository;
use app\core\services\catalog\BookService;
use yii\filters\AccessControl;
use yii\web\Controller;

class BookController extends Controller
{
    public function __construct($id, $module,
                                private readonly BookRepository $bookRepository,
                                private readonly BookService $bookService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionView(int $id)
    {
        $book = $this->bookRepository->find($id);
        $model = new BookForm($book);

        $bookAuthors = Author::find()
            ->andWhere(['id' => $model->authors])
            ->indexBy('id')
            ->all();

        return $this->render('view', [
            'book' => $book,
            'model' => $model,
            'authors' => array_map(function (Author $author) {
                return $author->getShortFullName();
            }, $bookAuthors),
        ]);
    }

    public function actionDelete(int $id)
    {
        $book = $this->bookRepository->find($id);
        $this->bookService->remove($book);

        return $this->redirect(['/book']);
    }
}
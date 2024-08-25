<?php

namespace app\controllers\redact;

use app\core\entities\catalog\Author;
use app\core\forms\catalog\BookForm;
use app\core\repositories\catalog\BookRepository;
use yii\filters\AccessControl;
use yii\web\Controller;

class BookController extends Controller
{
    private BookRepository $bookRepository;

    public function __construct($id, $module,
                                BookRepository $bookRepository,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bookRepository = $bookRepository;
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
}
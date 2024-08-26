<?php

namespace app\controllers\ajax;

use app\core\entities\catalog\Author;
use app\core\forms\catalog\BookForm;
use app\core\repositories\catalog\BookRepository;
use app\core\services\catalog\BookService;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class BookController extends AjaxController
{
    public function __construct($id, $module,
                                private BookRepository $bookRepository,
                                private BookService $bookService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionSearchAuthors(string $q = null, int $id = null): Response
    {
        $results = ['id' => '', 'text' => ''];
        if (!is_null($q)) {
            $authors = Author::find()
                ->where(['like', 'last_name', $q])
                ->limit(40)
                ->all();

            $results = array_map(function (Author $author) {
                return [
                    'id' => $author['id'],
                    'text' => $author->getShortFullName(),
                ];
            }, $authors);
        } elseif (!is_null($id)) {
            $author = Author::find()
                ->andWhere(['id' => $id])
                ->indexBy('id')
                ->asArray()
                ->one();

            if ($author) {
                $results = [
                    'id' => $author['id'],
                    'text' => $author['name'],
                ];
            }

        }

        return $this->asJson(['results' => $results]);
    }

    public function actionValidate(int $id = null): Response
    {
        if ($id) {
            $book = $this->bookRepository->get($id);
        }
        $post = Yii::$app->request->post();

        $model = new BookForm($book ?? null, []);
        $model->load($post);

        return $this->asJson(ActiveForm::validate($model));
    }

    public function actionUpdate(int $id = null)
    {
        $book = $this->bookRepository->get($id);
        $post = Yii::$app->request->post();

        $model = new BookForm($book ?? null, []);
        if ($model->load($post) && $model->validate()) {
            $this->bookService->update($book, $model);
        }

        return $this->asJson([
            'status' => 'success',
        ]);
    }
}
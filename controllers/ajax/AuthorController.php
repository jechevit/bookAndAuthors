<?php

namespace app\controllers\ajax;

use app\core\forms\catalog\AuthorForm;
use app\core\repositories\catalog\AuthorRepository;
use app\core\services\catalog\AuthorService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AuthorController extends Controller
{
    public function __construct($id, $module,
                                private readonly AuthorService $authorService,
                                private readonly AuthorRepository $authorRepository,
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
    public function actionValidate(int $id = null): Response
    {
        if ($id) {
            $author = $this->authorRepository->get($id);
        }
        $post = Yii::$app->request->post();

        $model = new AuthorForm($author ?? null, []);
        $model->load($post);

        return $this->asJson(ActiveForm::validate($model));
    }

    public function actionUpdate(int $id = null): Response
    {
        $author = $this->authorRepository->get($id);
        $post = Yii::$app->request->post();

        $model = new AuthorForm($author ?? null, []);
        if ($model->load($post) && $model->validate()) {
            $this->authorService->update($author, $model);
        }

        return $this->asJson([
            'status' => 'success',
            'id' => $author->id,
        ]);
    }

    public function actionCreate(): Response
    {
        $post = Yii::$app->request->post();

        $model = new AuthorForm($author ?? null, []);
        $model->load($post);
        if (!$model->validate()) {
            throw new \DomainException(implode("\n", $model->getFirstErrors()));
        }

        $author = $this->authorService->create($model);
        return $this->asJson([
            'status' => 'success',
            'id' => $author->id,
        ]);
    }
}
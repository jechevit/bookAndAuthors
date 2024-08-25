<?php

namespace app\controllers;

use app\core\forms\LoginForm;
use app\core\services\auth\AuthService;
use app\core\auth\Identity;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct($id, $module,
                                AuthService $authService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
    }

    /**
     * @return mixed
     */
    public function actionLogin(): mixed
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->auth($form);
                Yii::$app->user->login(new Identity($user), $form->rememberMe ? Yii::$app->params['user.rememberMeDuration'] : 0);
                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionLogout(): mixed
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
<?php

namespace app\controllers\ajax;

use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;

class AjaxController extends Controller
{
    public function behaviors(): array
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'ajaxFilter' => [
                'class' => AjaxFilter::class,
            ],
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

    /**
     * @param $id
     * @param $params
     * @return mixed
     */
    public function runAction($id, $params = []): mixed
    {
        try {
            return parent::runAction($id, $params);
        } catch (\Exception $e) {

            return [
                'exception' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ],
                'status' => 'error',
            ];
        }

    }
}
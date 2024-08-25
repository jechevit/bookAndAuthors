<?php

namespace app\core\services;

use Throwable;
use Yii;

class TransactionManager
{
    /**
     * @param callable $function
     * @return mixed
     * @throws Throwable
     */
    public function wrap(callable $function): mixed
    {
        return Yii::$app->db->transaction($function);
    }
}
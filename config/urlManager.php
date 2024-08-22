<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'cache' => false,
    'rules' => [
        '' => 'site/index',
        'contact' => 'contact/index',
        'signup' => 'signup/request',
        'signup/<_a:[\w-]+>' => 'signup/<_a>',
        '<_a:login|logout>' => 'auth/<_a>',
    ],
];
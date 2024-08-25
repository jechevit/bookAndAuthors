<?php


return [
    'staticPath' => dirname(__DIR__) . '/web/static',
    'staticHostInfo' => 'http://localhost:8000/static',
    'bsDependencyEnabled' => false,
    'bsVersion' => '5.x',
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'cookieDomain' => '.example.com',
];

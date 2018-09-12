<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'notificationService' => [
            'class' => \common\services\NotificationService::class
        ],
        'projectService' => [
            'class' => \common\services\ProjectService::class
        ],
        'emailService' => [
            'class' => \common\services\EmailService::class
        ]
    ],
    'modules' => [
        'chat' => [
            'class' => 'common\modules\chat\Module',
        ],
        'api' => [
            'class' => 'frontend\modules\api\Module',
        ],
    ],
];

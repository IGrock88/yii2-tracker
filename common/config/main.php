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
        'projectService' => [
            'class' => 'common\services\ProjectService'
        ],
        'emailService' => [
            'class' => 'common\services\EmailService'
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

<?php


use kartik\datecontrol\Module;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['auth'],
                    'logFile' => '@runtime/logs/auth.log',
                    'logVars' => ['_GET', '_POST', '!_POST.LoginForm', '_FILES', '_COOKIE', '_SESSION', '_SERVER']
                ],
            ],
        ],
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
        ],
        'taskService' => [
            'class' => \common\services\TaskService::class
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
                // ...
            ],
        ]
    ],
    'modules' => [
        'chat' => [
            'class' => 'common\modules\chat\Module',
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module',
        ],
        //документация http://demos.krajee.com/datecontrol
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',
            'displaySettings' => [
                Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm:ss',
            ],
            'saveSettings' => [
                Module::FORMAT_DATETIME => 'php:U',
            ],
            'displayTimezone' => 'Europe/Moscow',
            'autoWidget' => true,
            'autoWidgetSettings' => [
                Module::FORMAT_DATETIME => [
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'startDate' => date("Y-m-d H:i:s"),
                        'format' => 'yyyy-MM-dd H:m:s'
                    ]
                ],
            ],
        ]
    ],
];

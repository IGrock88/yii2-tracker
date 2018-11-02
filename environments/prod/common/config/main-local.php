<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=eu-cdbr-west-02.cleardb.net;dbname=heroku_69688f022b2f78a',
            'username' => 'b893eeef7c8a8e',
            'password' => '84beb004',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];

<?php

return [
    'id' => 'app-console',
    'class' => 'yii\console\Application',
    'basePath' => \Yii::getAlias('@tests'),
    'runtimePath' => \Yii::getAlias('@tests/_output'),
    'sourceLanguage' => 'en-US',
    'language' => 'ru',
    'bootstrap' => [],
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=yii2_entity',
            'username' => 'root',
            'password' => '',
        ],
        'user' => [
            'class' => \tests\components\TestUser::class,
            'identityClass' => \yii\web\IdentityInterface::class,
        ],
    ]
];

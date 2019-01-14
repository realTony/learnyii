<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$urlRules = require __DIR__.'/urlRules.php';
$config = parse_ini_file(__DIR__.'/../../secure/stickit.ini', true);
$config = [
    'id' => 'stickit',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'name' => 'STICKIT',
    'language' => 'ru-Ru',
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => $config['oauth_google_clientId'],
                    'clientSecret' => $config['oauth_google_clientSecret']
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => $config['oauth_facebook_clientId'],
                    'clientSecret' => $config['oauth_facebook_clientSecret']
                ]
            ]
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gZxNLSezjY7MWYGhogsz463Elr9nzDYf',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'view' => [
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => false,
                    'options' => [
                        'auto_reload' => true
                    ],
                    'globals' => [
                        'html' => '\yii\helpers\Html',
                        'url' => ['class' => 'yii\helpers\Url'],
                        'lang' => 'Yii'
                    ],
                    'uses' => [
                               'yii\helpers\Html',
                                'yii\widgets\Menu'
                    ],
                    'functions' => array(
                        't' => 'Yii::t',
                        'beginform' =>'yii\helpers\Html::beginForm',
                        'endform' =>'yii\helpers\Html::endForm',
                        'submitButton' =>'yii\helpers\Html::submitButton',
                        'connect' => 'dektrium\user\widgets\Connect::widget'
                    ),
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $urlRules,
        ],
        'i18n' =>[
            'translations' => [
                'app*' =>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php'
                    ]
                ]
            ]
        ]
    ],
    'modules' =>[
        'user' => [
            'class' => 'dektrium\user\Module'
        ],
        'myaccount' => [
            'class' => 'app\modules\myaccount\Module',
            // ... другие настройки модуля ...
        ],
        'blog' => [
            'class' => 'app\modules\blog\Module',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ]
    ],
    'layout' => 'main.twig',
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

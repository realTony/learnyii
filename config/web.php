<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$urlRules = require __DIR__.'/urlRules.php';
$config = parse_ini_file(__DIR__.'/../../secure/stickit.ini', true);
$config = [
    'id' => 'stickit',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log'
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'name' => ' STICKIT',
    'language' => 'ru-Ru',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'assetManager' => [
            'linkAssets' => true,
            'bundles' => array(
                'yii\web\JqueryAsset' => array(
                    'sourcePath' => '@web',
                    'js' => array(
                        'js/jquery.min.js',
                    ),
                ),
            )
        ],
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
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
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
//            'enableAutoLogin' => true,
//            'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => ['account#login'],
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
                        'connect' => 'dektrium\user\widgets\Connect::widget',
                        'csrfMetatags' => 'yii\helpers\Html::csrfMetaTags',
                        'getAvatar' => 'app\models\Profile::getUserAvatar',
                        'getUsername' => 'app\models\Profile::getUsername',
                        'getUserDate' => 'app\models\Profile::getUserDate'
                    ),
                    'filters' => [
                        'print_r' => 'print_r',
                        'var_dump' => 'var_dump'
                    ]
                ]
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $config['smtp_host'],
                'username' => $config['smtp_username'],
                'password' => $config['smtp_password'],
                'port' => '587',
                'encryption' => 'tls',
            ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
//            'viewPath' => '@common/mail'
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
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['ru' => 'ru-Ru', 'uk' => 'uk-Uk'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $urlRules,
            'ignoreLanguageUrlPatterns' => [
                // route pattern => url pattern
                '#^site/(login|register)#' => '#^(signin|signup)#',
            ],
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
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'myaccount/*',
            'rbac/*',
            'gii/*',
            'debug/*',
            'categories/*',
            'images/*',
            'news/*'
//            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'modules' =>[
        'user' => [
            'class' => 'app\modules\user\Module'
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
        ],
        'rbac' => [
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    /* 'userClassName' => 'app\models\User', */
                    'idField' => 'id',
                    'usernameField' => 'username',
                    'fullnameField' => 'username',
                    'searchClass' => 'app\models\UserSearch'
                ],
            ]
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

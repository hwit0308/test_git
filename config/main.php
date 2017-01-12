<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'apply',
    'homeUrl' => 'login',
    'language' => 'jp',
    'layout' => 'home',
    'bootstrap' => ['log'],
    'modules' => [
        'apply' => [
            'class' => 'backend\modules\apply\Apply',
        ],
        'applyBb' => [
            'class' => 'backend\modules\applyBb\ApplyBb',
        ],
        'goodMaster' => [
            'class' => 'backend\modules\goodMaster\GoodMaster',
        ],
        'staff' => [
            'class' => 'backend\modules\staff\Staff',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
            'downloadAction' => 'export',  //change default download action to your own export action.
                ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'urlManager' =>[
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'site/login',
                'logout' => 'site/logout',
                //module apply
                '/apply' => '/apply/default/index',
                '/apply/detail/<applyId:\d+>' => '/apply/default/detail',
                '/apply/mail_detail/<applyId:\d+>' => '/apply/default/mail-detail',
                '/apply/mail_success/<applyId:\d+>' => '/apply/default/mail-success',
                //module staff
                '/staff' => '/staff/default/index',
                '/staff/detail/<staffId:\w+>' => '/staff/default/detail',
                '/staff/edit/<staffId:\w+>' => '/staff/default/update',
                '/staff/add' => '/staff/default/update',
                '/staff/changepass/<staffId:\w+>' => '/staff/default/changepass',
                
                '/plan/edit/<planId:\d+>' => 'goodMaster/plan/save',
                '/plan/add' => 'goodMaster/plan/save',
                //modyle goodMaster
                '/plan' => '/goodMaster/plan/index',
                '/plan/detail/<planId:\w+>' => '/goodMaster/plan/detail',
                '/plan/edit/<planId:\d+>' => '/goodMaster/plan/save',
                '/plan/add' => 'goodMaster/plan/save',
                '/goods' => '/goodMaster/default/index',
                '/goods/detail/<goodsJan:\w+>' => '/goodMaster/default/detail',
                //'/goods/add' => '/goodMaster/default/add',
                '/goods/edit/<goodsJan:\w+>' => '/goodMaster/default/save',
                '/goods/add' => '/goodMaster/default/save',
                '/goods/drop/<goodsJan:\w+>' => '/goodMaster/default/drop',
                '/goods/import' => '/goodMaster/default/import',
                '/goods/message' => '/goodMaster/default/message',
                '/option' => '/goodMaster/option/index',
                '/option/detail/<packCode:\w+>/<code:\w+>' => '/goodMaster/option/detail',
                
                '/option/edit/<packCode:\w+>/<code:\w+>' => '/goodMaster/option/save',
                '/option/add' => 'goodMaster/option/save',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => ['api'],
                    'logFile' => '@app/runtime/logs/api.log',
                    'prefix' => function ($message) {
                        $request = Yii::$app->getRequest();
                        $ip = $request instanceof Request ? $request->getUserIP() : '-';
                        /* @var $session \yii\web\Session */
                        $session = Yii::$app->has('session', true) ? Yii::$app->get('session') : null;
                        $sessionID = $session && $session->getIsActive() ? $session->getId() : '-';
                        $pid = getmypid();
                        return "[$ip][$pid][$sessionID]";
                    },
                    'logVars' => ['_POST', '_GET', '_COOKIE', '_SESSION'],
                    'customVars' => ["_SERVER" => ['HTTP_USER_AGENT', 'REQUEST_URI']],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => ['import'],
                    'logFile' => '@app/runtime/logs/import.log',
                    'prefix' => function ($message) {
                        $request = Yii::$app->getRequest();
                        $ip = $request instanceof Request ? $request->getUserIP() : '-';
                        /* @var $session \yii\web\Session */
                        $session = Yii::$app->has('session', true) ? Yii::$app->get('session') : null;
                        $sessionID = $session && $session->getIsActive() ? $session->getId() : '-';
                        $pid = getmypid();
                        return "[$ip][$pid][$sessionID]";
                    },
                    'logVars' => ['_POST', '_GET', '_COOKIE', '_SESSION'],
                    'customVars' => ["_SERVER" => ['HTTP_USER_AGENT', 'REQUEST_URI']],
                ]
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
        'request' => [
            'baseUrl' => '/backend',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'xxxxxxx',
            ],
    ],
    'params' => $params,
];

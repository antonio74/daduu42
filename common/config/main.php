<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
        ],
       /* 'view' => [
            'class' => 'yii\web\View',
                'theme' => [
                  'class' => 'yii\base\Theme',
                  'pathMap' => ['@app/views' => 'themes/material-default'],
                  'baseUrl'   => '@web/themes/material-default'
                ]
        ]*/

    ],
];

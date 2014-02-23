<?php
/**
 * Configuration parameters common to all entry points.
 */
return [
    'preload' => ['log'],
    'import' => [
        'common.components.*',
        'common.models.*',
        // The following two imports are polymorphic and will resolve against wherever the `basePath` is pointing to.
        // We have components and models in all entry points anyway
        'application.components.*',
        'application.models.*'
    ],
    'components' => [
        'db' => [
            'schemaCachingDuration' => PRODUCTION_MODE ? 86400000 : 0, // 86400000 == 60*60*24*1000 seconds == 1000 days
            'enableParamLogging' => !PRODUCTION_MODE,
            'charset' => 'utf8'
        ],
        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '/',
        ],
        'cache' => extension_loaded('apc')
                ? [
                    'class' => 'CApcCache',
                ]
                : [
                    'class' => 'CDbCache',
                    'connectionID' => 'db',
                    'autoCreateCacheTable' => true,
                    'cacheTableName' => 'cache',
                ],
        'messages' => [
            'basePath' => 'common/messages'
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                'logFile' => [
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                    'filter' => 'CLogFilter'
                ],
            ]
        ],
    ]
];

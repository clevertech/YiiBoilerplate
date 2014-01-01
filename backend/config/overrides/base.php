<?php
/**
 * Base config overrides for backend application
 */
return [
    // So our relative path aliases will resolve against the `/backend` subdirectory and not nonexistent `/protected`
    'basePath' => 'backend',
    'import' => [
        'application.controllers.*',
        'application.controllers.actions.*',
        'common.actions.*'
    ],
    'controllerMap' => [
        // Overriding the controller ID so we have prettier URLs without meddling with URL rules
        'site' => 'BackendSiteController'
    ],
    'components' => [
        // Backend uses the YiiBooster package for its UI
        'bootstrap' => [
            // `bootstrap` path alias was defined in global init script
            'class' => 'bootstrap.components.Bootstrap'
        ],
        'errorHandler' => array(
            // Installing our own error page.
            'errorAction' => 'site/error'
        ),
        'urlManager' => [
            // Some sane usability rules
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

                // Your other rules here...
            ]
        ],
    ],
];
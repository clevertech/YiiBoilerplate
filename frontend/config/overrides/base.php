<?php /** hijarian @ 27.10.13 13:03 */
/**
 * Base overrides for frontend application
 */
return array(
    // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
    'basePath' => 'frontend',
    // set parameters
    // preload components required before running applications
    // @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
    'preload' => array('log'),
    // @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
    'language' => 'en',

    'controllerMap' => array(
        'site' => 'application.controllers.FrontendSiteController'
    ),
    // uncomment if a theme is used
    /*'theme' => '',*/
    // setup import paths aliases
    // @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
    'import' => array(
        'application.components.*',
        'application.controllers.*',
        'application.controllers.actions.*',
        'application.models.*',
        'common.actions.*',
    ),
    /* uncomment and set if required */
    // @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
    /* 'modules' => array(), */
    'components' => array(
        'errorHandler' => array(
            // @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
            'errorAction' => 'site/error'
        ),
        'urlManager' => array(
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            )
        ),
    ),
);
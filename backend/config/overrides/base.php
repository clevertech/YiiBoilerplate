<?php /** hijarian @ 27.10.13 13:03 */
/**
 * Base overrides for backend application
 */
return array(
    // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
    'basePath' => 'backend',
    // set parameters
    // preload components required before running applications
    // @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
    'preload' => array('log'),
    // @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
    'language' => 'en',
    // uncomment if a theme is used
    /*'theme' => '',*/
    // setup import paths aliases
    // @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
    'import' => array(
        // uncomment if behaviors are required
        // you can also import a specific one
        /* 'common.extensions.behaviors.*', */
        // uncomment if validators on common folder are required
        /* 'common.extensions.validators.*', */
        'application.components.*',
        'application.controllers.*',
        'application.controllers.actions.*',
        'application.models.*',
        'common.actions.*'
    ),
    /* uncomment and set if required */
    // @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
    'modules' => array(
        /* Backend can afford gii support */
//        'gii' => array(
//            'class' => 'system.gii.GiiModule',
//            'password' => 'pick up a password here',
//            'ipFilters' => array('127.0.0.1'),
//        )
    ),
    'controllerMap' => array(
        'site' => 'BackendSiteController'
    ),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        /* The following enhances performance, but will not work in Windows. */
//        'assetManager' => array(
//            'linkAssets' => true
//        ),
        'bootstrap' => array(
            'class' => 'vendor.clevertech.yii-booster.src.components.Bootstrap'
        ),
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
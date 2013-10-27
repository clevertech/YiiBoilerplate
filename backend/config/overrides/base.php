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
        'backend.components.*',
        'backend.controllers.*',
        'backend.models.*'
    ),
    /* uncomment and set if required */
    // @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
    /* 'modules' => array(), */
    'components' => array(
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
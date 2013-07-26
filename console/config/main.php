<?php
/**
 * main.php
 *
 * Configuration file for console applications
 */

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', __DIR__ . "/../..");
Yii::setPathOfAlias('common', __DIR__ . "/../../common");

/* uncomment if the following aliases are required */
//Yii::setPathOfAlias('frontend', $root . DIRECTORY_SEPARATOR . 'frontend');
//Yii::setPathOfAlias('backend', $root . DIRECTORY_SEPARATOR . 'backend');

return CMap::mergeArray(
	require(__DIR__ . "/../../common/config/main.php"),
	array(
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
		'basePath' => 'console',
		// preload components required before running applications
		// @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
		'preload' => array('log'),

		// setup import paths aliases
		// @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
		'import' => array(
			'application.components.*',
			'application.models.*',
			/* uncomment to use frontend models */
			/*'root.frontend.models.*',*/
			/* uncomment to use frontend components */
			/*'root.frontend.components.*',*/
			/* uncomment to use backend components */
			/*'root.backend.components.*',*/
		),
		/* locate migrations folder if necessary */
		'commandMap' => array(
			'migrate' => array(
				'class' => 'system.cli.commands.MigrateCommand',
				/* change if required */
				'migrationPath' => 'root.console.migrations'
			)
		),
		'components' => array(
			'log' => array(
				'class' => 'CLogRouter',
				'routes' => array(
					'main' => array(
						'class' => 'CFileLogRoute',
						'levels' => 'error, warning',
						'filter' => 'CLogFilter'
					)
				)
			),
			/* uncomment and configure to suit your needs */
			/*
			 'request' => array(
				'hostInfo' => 'http://localhost',
				'baseUrl' => '/bp'
			),
			*/
		),
	),
	(file_exists(__DIR__ . '/main-env.php') ? require(__DIR__ . '/main-env.php') : array()),
	(file_exists(__DIR__ . '/main-local.php') ? require(__DIR__ . '/main-local.php') : array())
);


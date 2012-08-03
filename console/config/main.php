<?php
/**
 * main.php
 *
 * Configuration file for console applications
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 12:15 PM
 */
$currentDir = dirname(__FILE__);

$root = $currentDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

$params = require_once($currentDir . DIRECTORY_SEPARATOR . 'params.php');

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('common', $root . DIRECTORY_SEPARATOR . 'common');

/* uncomment if the following aliases are required */
//Yii::setPathOfAlias('frontend', $root . DIRECTORY_SEPARATOR . 'frontend');
//Yii::setPathOfAlias('backend', $root . DIRECTORY_SEPARATOR . 'backend');

$mainLocalFile = $currentDir . DIRECTORY_SEPARATOR . 'main-local.php';
$mainLocalConfiguration = file_exists($mainLocalFile) ? require($mainLocalFile) : array();

$mainEnvFile = $currentDir . DIRECTORY_SEPARATOR . 'main-env.php';
$mainEnvConfiguration = file_exists($mainEnvFile) ? require($mainEnvFile) : array();

return CMap::mergeArray(
	array(
		// @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
		'basePath' => 'console',
		// set parameters
		'params' => $params,
		// preload components required before running applications
		// @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
		'preload' => array('log'),

		// setup import paths aliases
		// @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
		'import' => array(
			'common.components.*',
			'common.extensions.*',
			'common.models.*',
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
			'db' => array(
				'connectionString' => $params['db.connectionString'],
				'username' => $params['db.username'],
				'password' => $params['db.password'],
				'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
				'enableParamLogging' => YII_DEBUG,
				'charset' => 'utf8'
			),
			/* uncomment if we require to run commands against test database */
			/*
			 'testdb' => array(
				'class' => 'CDbConnection',
				'connectionString' => $params['testdb.connectionString'],
				'username' => $params['testdb.username'],
				'password' => $params['testdb.password'],
				'charset' => 'utf8'
			),
			*/
			'urlManager' => array(
				'urlFormat' => 'path',
				'showScriptName' => false,
				'urlSuffix' => '/',
				'rules' => $params['url.rules']
			),
			/* uncomment and configure upon your project requirements */
			/*
			'authManager' => array(
				'class' => 'CDbAuthManager',
				'itemTable' => 'auth_item',
				'itemChildTable' => 'auth_item_child',
				'assignmentTable' => 'auth_assignment',
			   ),
			*/
			'cache' => $params['cache.core'],
			'contentCache' => $params['cache.content']
		),
	),
	CMap::mergeArray($mainEnvConfiguration, $mainLocalConfiguration)
);


<?php
/**
 * main.php
 *
 * Common configuration file for backend, console and frontend applications
 */
Yii::setPathOfAlias('root', __DIR__ . '/../..');
Yii::setPathOfAlias('common', __DIR__ . '/../../common');

return CMap::mergeArray(
	array(
		'import' => array(
			'common.components.*',
			'common.models.*',
		),
		'components' => array(
			'db' => array(
				'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
				'enableParamLogging' => YII_DEBUG,
				'charset' => 'utf8'
			),
			'urlManager' => array(
				'urlFormat' => 'path',
				'showScriptName' => false,
				'urlSuffix' => '/',
			),
			'cache' => extension_loaded('apc') ?
				array(
					'class' => 'CApcCache',
				) :
				array(
					'class' => 'CDbCache',
					'connectionID' => 'db',
					'autoCreateCacheTable' => true,
					'cacheTableName' => 'cache',
				),
		)
	),
	(file_exists(__DIR__ . '/main-env.php') ? require(__DIR__ . '/main-env.php') : array()),
	(file_exists(__DIR__ . '/main-local.php') ? require(__DIR__ . '/main-local.php') : array())
);

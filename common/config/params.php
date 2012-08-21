<?php
/**
 * params.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 1:39 PM
 */
/**
 * Parameters shared by all applications.
 * Please put environment-sensitive parameters in env/params-{environmentcode}.php
 */
$commonConfigDir = dirname(__FILE__);

// get local parameters in
$commonParamsLocalFile = $commonConfigDir . DIRECTORY_SEPARATOR . 'params-local.php';
$commonParamsLocal = file_exists($commonParamsLocalFile) ? require ($commonParamsLocalFile) : array();

// if exists, include it, otherwise set as an empty array
$commonEnvParamsFile = $commonConfigDir . DIRECTORY_SEPARATOR . 'params-env.php';
$commonEnvParams = file_exists($commonEnvParamsFile) ? require($commonEnvParamsFile) : array();

return CMap::mergeArray(array(
	// cache settings -if APC is not loaded, then use CDbCache
	'cache.core' => extension_loaded('apc') ?
		array(
			'class' => 'CApcCache',
		) :
		array(
			'class' => 'CDbCache',
			'connectionID' => 'db',
			'autoCreateCacheTable' => true,
			'cacheTableName' => 'cache',
		),
	'cache.content' => array(
		'class' => 'CDbCache',
		'connectionID' => 'db',
		'autoCreateCacheTable' => true,
		'cacheTableName' => 'cache',
	),

	// url rules needed by CUrlManager
	'url.rules' => array(
		'<controller:\w+>/<id:\d+>' => '<controller>/view',
		'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
		'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
	),
	'php.exePath' => '/usr/bin/php'
), CMap::mergeArray($commonEnvParams, $commonParamsLocal));
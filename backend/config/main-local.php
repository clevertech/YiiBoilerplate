<?php
/**
 * main-local.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 6:25 PM
 *
 * This file should have the configuration settings of your backend application that will be merged to the main.php.
 *
 * This configurations should be only related to your development machine.
 */

return array(
	'components' => array(
//		'db'=> array(
//			'connectionString' => $params['db.connectionString'],
//			'username' => $params['db.username'],
//			'password' => $params['db.password'],
//			'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
//			'enableParamLogging' => Yii_DEBUG,
//			'charset' => 'utf8'
//		),
		'urlManager' => array(
			'urlFormat' => $params['url.format'],
			'showScriptName' => $params['url.showScriptName'],
			'rules' => $params['url.rules']
		)
	)
);
<?php
/**
 * index.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 11:13 AM
 */

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// On dev display all errors
if (YII_DEBUG) {
//	error_reporting(-1);
//	ini_set('display_errors', true);
}

date_default_timezone_set('UTC');

chdir(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');

//$root=dirname(__FILE__).'/..';
//$common=$root.'/../common';

require_once('common' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Yii' . DIRECTORY_SEPARATOR . 'yii.php');
$config = require('frontend' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php');
require_once('common' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'WebApplication.php');
require_once('common' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'global.php');


$app = Yii::createApplication('WebApplication', $config);

/* please, uncomment the following if you are using ZF library */
/*
Yii::import('common.extensions.EZendAutoloader', true);

EZendAutoloader::$prefixes = array('Zend');
EZendAutoloader::$basePath = Yii::getPathOfAlias('common.lib') . DIRECTORY_SEPARATOR;

Yii::registerAutoloader(array("EZendAutoloader", "loadClass"), true);
*/

$app->run();

/* uncomment if you wish to debug your resulting config */
/* echo '<pre>' . dump($config) . '</pre>'; */

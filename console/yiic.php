<?php
/* setup default time zone */
date_default_timezone_set('UTC');

/* change dir to root */
chdir(dirname(__FILE__) . '/..');

/* change to set debug mode */
// defined('YII_DEBUG') or define('YII_DEBUG',true);

$config =  'console/config/main.php';

require_once('common/lib/Yii/yii.php');
require_once('common/lib/global.php');
require_once('common/lib/Yii/yiic.php');
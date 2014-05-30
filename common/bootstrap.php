<?php
# This is the global bootstrap file containing code which should be run for *every* entry point.

# Path to the real root of project
define('ROOT_DIR', realpath(__DIR__ . '/../'));

# If master ordered us to work in production mode, remember it.
define('PRODUCTION_MODE', require(__DIR__ . '/check_prod_mode.php'));
if (!PRODUCTION_MODE) require(__DIR__ . '/debugmode.php');

# If we have autoloader from Composer, use it.
if (file_exists(ROOT_DIR . '/vendor/autoload.php'))
    require ROOT_DIR . '/vendor/autoload.php';

# NOTE that you must declare `YII_DEBUG` and `YII_TRACE_LEVEL`
# BEFORE loading the framework or it will have no effect on Yii!

# Launching the Yii framework.
require_once ROOT_DIR . '/vendor/yiisoft/yii/framework/YiiBase.php';
# Include our own Yii singleton definition
require_once ROOT_DIR . '/common/components/Yii.php';
# Include our own base WebApplication class
require_once ROOT_DIR . '/common/components/WebApplication.php';

# Some global aliases
Yii::setPathOfAlias('root', ROOT_DIR);
Yii::setPathOfAlias('common', ROOT_DIR . '/common');
Yii::setPathOfAlias('vendor', ROOT_DIR . '/vendor');

# Global timezone setting
date_default_timezone_set('UTC');

# Set the internal character encoding
mb_internal_encoding('UTF-8');

# We're in XXI century, so let's use modern locale already
setlocale(
    LC_CTYPE,
    'C.UTF-8', // libc >= 2.13
    'C.utf8', // different spelling
    'en_US.UTF-8', // fallback to lowest common denominator
    'en_US.utf8' // different spelling for fallback
);

# PWD will be the root dir of the project
chdir(ROOT_DIR);

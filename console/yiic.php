<?php
# This is the entry point for console application.
#
# We do not use the built-in `yiic.php` because of our own class including order.

require_once(__DIR__ . '/../common/bootstrap.php');
# Our own boilerplate for ConsoleApplication
require_once(ROOT_DIR . '/console/components/ConsoleApplication.php');

# fix for fcgi
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

/** @var ConsoleApplication $app */
$app = Yii::createApplication(
    'ConsoleApplication',
    ROOT_DIR . '/console/config/main.php'
);
$app->commandRunner->addCommands(YII_PATH . '/cli/commands');
$app->commandRunner->addCommands(@getenv('YII_CONSOLE_COMMANDS'));
$app->run();



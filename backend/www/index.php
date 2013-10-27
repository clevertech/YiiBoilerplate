<?php
/**
 * backend/www/index.php
 *
 * Entry point for backend
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 11:13 AM
 *
 * @author: mark safronov <hijarian@gmail.com>
 */

// Loading project default init code for all entry points.
require __DIR__.'/../../common/bootstrap.php';

// Setting up the frontend-specific aliases
Yii::setPathOfAlias('backend', ROOT_DIR .'/backend');
Yii::setPathOfAlias('www', ROOT_DIR . '/backend/www');

// As we are using BootstrapFilter to include Booster, we have to define 'bootstrap' alias ourselves
Yii::setPathOfAlias('bootstrap', ROOT_DIR . '/vendor/clevertech/yii-booster/src');

// We use our custom-made WebApplication component as base class for backend app.
require_once ROOT_DIR.'/backend/components/BackendWebApplication.php';

Yii::createApplication(
    'BackendWebApplication',
    ROOT_DIR.'/backend/config/main.php'
)->run();


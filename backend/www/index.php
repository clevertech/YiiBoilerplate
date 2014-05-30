<?php
/**
 * Entry point script for backend.
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * @author: mark safronov <hijarian@gmail.com>
 */

# Loading project default init code for all entry points.
require __DIR__ . '/../../common/bootstrap.php';

# Setting up the frontend-specific aliases
Yii::setPathOfAlias('backend', ROOT_DIR .'/backend');
Yii::setPathOfAlias('www', ROOT_DIR . '/backend/www');

# As we are using BootstrapFilter to include Booster, we have to define 'bootstrap' alias ourselves
# Note that we are binding to Composer-installed version of YiiBooster
Yii::setPathOfAlias('bootstrap', ROOT_DIR . '/vendor/clevertech/yii-booster/src');

# We use our custom-made WebApplication component as base class for backend app.
require_once ROOT_DIR . '/backend/components/BackendWebApplication.php';

# For obvious reasons, backend entry point is constructed of specialised WebApplication and config
Yii::createApplication(
    'BackendWebApplication',
    ROOT_DIR . '/backend/config/main.php'
)->run();


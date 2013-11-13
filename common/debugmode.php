<?php
/**
 * This code snippet enables global full debug mode.
 *
 * Whether it'll be executed or not depends on the existence of file named 'debugmodeon' in the project root dir.
 * If such a file exists (contents are not important) then global bootstrap will execute the following code.
*/

# Our custom marker for debug mode
define('DEBUG_MODE', true);

# Please be sure that both of the following constants are NOT defined elsewhere.
# `defined` checks were removed intentionally.
#
# Yii's marker to note that we need Yii::trace() enabled;
define('YII_DEBUG', true);
# Stacktraces 3 level deep
define('YII_TRACE_LEVEL', 3);

# NOTE: any Yii tracing to the files or browser window will happen only if you setup the CLogRoutes in the config!
# Until then, YII_DEBUG and YII_TRACE_LEVEL constants are meaningless.
#
# In debug mode we really want to print errors to client
ini_set('display_errors', true);
# Report absolutely everything
error_reporting(-1);

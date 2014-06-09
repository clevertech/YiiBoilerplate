<?php
/**
 * This is where the ultimate config for backend entry point is being constructed.
 * Four parts are used in it:
 * 1. Global config defined in `common/config/main.php`
 * Note that this config itself is assembled the same way from three parts.
 * 2. Base overrides for backend entry point.
 * 3. Possible current environment-specific overrides for backend entry point
 * 4. Possible local overrides for backend entry point.
 */
return CMap::mergeArray(
    (require ROOT_DIR . '/common/config/main.php'),
    (require __DIR__ . '/overrides/base.php'),
    (file_exists(__DIR__ . '/overrides/environment.php') ? require(__DIR__ . '/overrides/environment.php') : array()),
    (file_exists(__DIR__ . '/overrides/local.php') ? require(__DIR__ . '/overrides/local.php') : array())
);

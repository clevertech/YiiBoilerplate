<?php
/**
 * Check for whether we are in production mode,
 * where we should compile all configs, combine assets,
 * disable error output, switch logging modes and do all other fun stuff.
 *
 * NOTE that we use ROOT_DIR here so this file has to be required after the `bootstrap.php`
 * or within it.
 *
 * This script intentionally returns a boolean.
 *
 * Three methods of launching app in production mode:
 *
 * 1. Place file named `PRODUCTION_MODE` (contents irrelevant) to the root of codebase.
 * 2. Setup your web server so in $_SERVER there'll be the true-ish value under the key "PRODUCTION_MODE".
 * 3. Run your web server in environment where the environment variable named "PRODUCTION_MODE" is set and have a true-ish value
 */
return (bool)(
	file_exists(ROOT_DIR . '/PRODUCTION_MODE') or
	(bool)@$_ENV['PRODUCTION_MODE'] or
	(bool)@$_SERVER['PRODUCTION_MODE']
);

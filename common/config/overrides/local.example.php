<?php
/**
 * This is an example for local configuration for the individual developer's machine.
 * Normally everything you will need to configure is the DB connection settings.
 *
 * Copy this example file in the same directory but renaming it to just `local.php`
 */
return array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=boilerplate',
            'username' => 'boilerplate',
            'password' => 'boilerplate',
        )
    ),
);

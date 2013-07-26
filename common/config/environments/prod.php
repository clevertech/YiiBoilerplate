<?php
/**
 * prod.php
 *
 * Common parameters for the application on production
 */
return array(
	'components' => array(
		// DB connection configurations. Set proper credentials for you application
		'db' => array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=yiibp',
			'username' => 'prod-db-username',
			'password' => 'long-strong-password',
		)
	),
	'params' => array(
		'env.code' => 'prod'
	)
);

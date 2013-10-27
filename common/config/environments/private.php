<?php
/**
 * private.php
 *
 * Common parameters for the application on private -your local environment
 */
return array(
	'modules' => array(
        // This way gii will be available only in "private" environment set
        // More than that, it will generate code in whatever endpoint it is placed.
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => 'clevertech'
		)
	),
	'params' => array(
		'env.code' => 'private'
	)
);

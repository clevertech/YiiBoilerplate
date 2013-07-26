<?php
/**
 * params-prod.php
 *
 * Common parameters for the application on production
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 1:41 PM
 */
/**
 * Replace following tokens for correspondent configuration data
 *
 * {DATABASE-NAME} ->   database name
 * {DATABASE-HOST} -> database server host name or ip address
 * {DATABASE-USERNAME} -> user name access
 * {DATABASE-PASSWORD} -> user password
 *
 * {DATABASE-TEST-NAME} ->   Test database name
 * {DATABASE-TEST-HOST} -> Test database server host name or ip address
 * {DATABASE-USERNAME} -> Test user name access
 * {DATABASE-PASSWORD} -> Test user password
 */
return array(
	// DB connection configurations
	'db.name' => '',
	'db.connectionString' => 'mysql:host={DATABASE-HOST};dbname={DATABASE-NAME}',
	'db.username' => '{DATABASE-USERNAME}',
	'db.password' => '{DATABASE-PASSWORD}',

	// test database {
	'testdb.name' => '',
	'testdb.connectionString' => 'mysql:host={DATABASE-HOST};dbname={DATABASE-NAME}_test',
	'testdb.username' => '{DATABASE-USERNAME}',
	'testdb.password' => '{DATABASE-PASSWORD}',
    'params' => array(
        'env.code' => 'prod'
    )
);

<?php
/**
 * Installation of users table.
 *
 * @package migrations
 */
class m120805_131754_user_table_migration extends CDbMigration
{
	public function up()
	{
		$this->execute('CREATE TABLE `user` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`username` varchar(45) DEFAULT NULL,
			`password` varchar(255) DEFAULT NULL,
			`salt` varchar(255) DEFAULT NULL,
			`password_strategy` varchar(50) DEFAULT NULL,
			`requires_new_password` tinyint(1) DEFAULT NULL,
			`email` varchar(255) DEFAULT NULL,
			`login_attempts` int(11) DEFAULT NULL,
			`login_time` int(11) DEFAULT NULL,
			`login_ip` varchar(32) DEFAULT NULL,
			`validation_key` varchar(255) DEFAULT NULL,
			`create_id` int(11) DEFAULT NULL,
			`create_time` int(11) DEFAULT NULL,
			`update_id` int(11) DEFAULT NULL,
			`update_time` int(11) DEFAULT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `username` (`username`),
			UNIQUE KEY `email` (`email`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('user');
	}
}

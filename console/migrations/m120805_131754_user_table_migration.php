<?php
/**
 * m120805_131754_user_table_migration.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 8/12/12
 * Time: 9:52 PM
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
		) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8');

		/* add demo users */
		$demoUser = new User();
		$demoUser->username = "demo";
		$demoUser->email = "demo@clevertech.biz";
		$demoUser->password = "clevertech";

		$demoUser->save();

		$adminUser = new User();
		$adminUser->username = "admin";
		$adminUser->email = "admin@clevertech.biz";
		$adminUser->password = "clevertech";

		$adminUser->save();

	}

	public function down()
	{
		$this->dropTable('user');
	}
}
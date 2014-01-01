<?php
/**
 * Delete this migration if you don't need a demo users
 *
 * @package migrations
 */
class m130721_220705_add_demo_users extends CDbMigration
{
	public function safeUp()
	{
		Yii::import('common.extensions.behaviors.password.*');
		$bcrypt = new ABcryptPasswordStrategy();

		$this->insert('user', array(
			'username' => 'admin',
			'email' => 'admin@example.com',
			'password' => $bcrypt->encode('smart_password'),
			'salt' => $bcrypt->getSalt(),
			'password_strategy' => 'bcrypt'
		));

		$this->insert('user', array(
			'username' => 'demo',
			'email' => 'demo@example.com',
			'password' => $bcrypt->encode('strong_password'),
			'salt' => $bcrypt->getSalt(),
			'password_strategy' => 'bcrypt'
		));
	}

	public function down()
	{
		$this->delete('user', 'email in ("admin@example.com", "demo@example.com")');
	}
}

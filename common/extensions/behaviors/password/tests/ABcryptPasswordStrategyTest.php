<?php
Yii::import("packages.passwordStrategy.*");
Yii::import("packages.users.models.*");
/**
 * Tests for the {@link ABcryptPasswordStrategy} class.
 * @author Charles Pick
 * @package packages.passwordStrategy
 */
class ABcryptPasswordStrategyTest extends CTestCase
{
	public function testEncode()
	{
		$strategy = new ABcryptPasswordStrategy();
		$strategy->getSalt(true);
		$password = "qwerty1";
		$this->assertFalse($strategy->compare("test",$strategy->encode($password)));
		$this->assertTrue($strategy->compare("qwerty1",$strategy->encode($password)));
	}


}

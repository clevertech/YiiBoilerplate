<?php
Yii::import("packages.passwordStrategy.*");
Yii::import("packages.users.models.*");
/**
 * Tests for the {@link AHashPasswordStrategy} class.
 * @author Charles Pick
 * @package packages.passwordStrategy
 */
class AHashPasswordStrategyTest extends CTestCase
{
	public function testEncode()
	{
		$strategy = new AHashPasswordStrategy();
		$strategy->getSalt(true);
		$password = "qwerty1";

		$this->assertFalse($strategy->compare("test",$strategy->encode($password)));
		$this->assertTrue($strategy->compare("qwerty1",$strategy->encode($password)));
	}

	public function testCanUpgradeTo()
	{
		$strategy1 = new AHashPasswordStrategy();
		$strategy1->minLength = 8;
		$strategy2 = new ALegacyMd5PasswordStrategy();
		$strategy2->minLength = 6;
		$this->assertTrue($strategy1->canUpgradeTo($strategy2));
		$this->assertFalse($strategy2->canUpgradeTo($strategy1));
	}

	public function testValidateAttribute()
	{
		$model = new MockUserModel();
		$model->password = "123";
		$this->assertFalse($model->validate()); // too short
		$model->clearErrors();
		$model->password = "12345678";
		$this->assertFalse($model->validate()); // needs upper case
		$model->clearErrors();
		$model->password = "ABCDEFGHI";
		$this->assertFalse($model->validate()); // needs digits
		$model->clearErrors();
		$model->password = "ABXCXVSD123";
		$this->assertFalse($model->validate()); // needs lower case letters
		$model->clearErrors();
		$model->password = "123asbASV";
		$this->assertFalse($model->validate()); // needs special characters
		$model->clearErrors();
		$model->password = "123%$^asbASV";
		$this->assertTrue($model->validate()); // woop
	}
}

class MockUserModel extends AUser
{
	public $password;
	public $salt;
	public $passwordStrategy;

	public function tableName()
	{
		return "users";
	}
	public function behaviors()
	{
		return array(
			"APasswordBehavior" => array(
				"class" => "APasswordBehavior",
				"defaultStrategyName" => "sha1",
				"strategies" => array(
					"sha1" => array(
						"class" => "AHashPasswordStrategy",
						"minUpperCaseLetters" => 2,
						"minLowerCaseLetters" => 2,
						"minSpecialCharacters" => 2,
						"minLength" => 8,
						"minDigits" => 2,
					)
				)

			)
		);
	}

}
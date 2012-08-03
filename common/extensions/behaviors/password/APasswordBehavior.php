<?php

/**
 * Provides password encoding and verification functionality for active records.
 * Also allows multiple password strategies to be used for the same model.
 * This is useful when upgrading legacy authentication systems to newer platforms,
 * user's passwords can be validated using the legacy password strategy, and upgraded
 * to the new password strategy on the fly.
 *
 * <pre>
 * $user = new User;
 * $behavior = new APasswordBehavior;
 * $behavior->defaultStrategyName = "hash";
 * $behavior->strategies = array(
 * 	"hash" => array(
 *		"class" => "packages.passwordStrategy.AHashPasswordStrategy",
 * 		"minLength" => 8
 *  ),
 * 	"legacy" => array(
 * 		"class" => "packages.passwordStrategy.ALegacyMd5Strategy",
 * 		"minLength" => 8
 *  ),
 * );
 * $user->attachBehavior("APasswordBehavior", $behavior);
 * $user->password = "qwerty";
 * $user->validate(); // false - password too short
 * $user->clearErrors();
 * $user->password = "qwerty1234";
 * $user->validate(); // true - password long enough
 * $user->save();
 * echo $user->password; // the newly hashed and salted password
 * </pre>
 *
 * @author Charles Pick
 * @package packages.passwordStrategy
 */
class APasswordBehavior extends CActiveRecordBehavior {
	/**
	 * The name of the attribute that contains the password salt
	 * @var string
	 */
	public $saltAttribute = "salt";

	/**
	 * The name of the attribute that contains the encoded password
	 * @var string
	 */
	public $passwordAttribute = "password";

	/**
	 * The name of the attribute that contains the password strategy name
	 * @var string
	 */
	public $strategyAttribute ="passwordStrategy";

	/**
	 * The name of the attribute that determines whether a user requires a new password or not
	 * @var string
	 */
	public $requireNewPasswordAttribute = "requiresNewPassword";

	/**
	 * The name of the default password strategy
	 * @var string
	 */
	public $defaultStrategyName;

	/**
	 * Whether to automatically upgrade users on password strategies other than the default.
	 * If this is true, user passwords will be reencoded with the new strategy when they
	 * successfully authenticate with an old strategy.
	 * @var boolean
	 */
	public $autoUpgrade = true;

	/**
	 * An array of supported password strategies.
	 * <pre>
	 * array(
	 * 	"hash" => array(
	 *		"class" => "packages.passwordStrategy.AHashPasswordStrategy",
	 * 		"hashMethod" => array("sha1"),
	 * 		"workFactor" => 50
	 * 	),
	 * 	"md5" => array(
	 * 		"class" => "packages.passwordStrategy.ALegacyMd5PasswordStrategy"
	 *  ),
	 * )
	 * </pre>
	 * @var array
	 */
	protected $_strategies = array();

	/**
	 * Holds the hashed password, used to determine whether the user has changed their password
	 * @var string
	 */
	private $_hashedPassword;

	/**
	 * Sets the strategies to use
	 * @param APasswordStrategy[]|array $strategies the strategies to add
	 */
	public function setStrategies($strategies)
	{
		foreach($strategies as $name => $strategy) {
			if (!($strategy instanceof APasswordStrategy)) {
				$strategy = Yii::createComponent($strategy);
			}
			$strategy->name = $name;
			$strategies[$name] = $strategy;
		}
		$this->_strategies = $strategies;
	}

	/**
	 * Gets the password strategies
	 * @return array the password strategies
	 */
	public function getStrategies()
	{
		return $this->_strategies;
	}

	/**
	 * Gets the default password strategy
	 * @return APasswordStrategy|boolean the default password strategy, or false if none is configured
	 */
	public function getDefaultStrategy()
	{
		if (isset($this->_strategies[$this->defaultStrategyName])) {
			return $this->_strategies[$this->defaultStrategyName];
		}
		return false;
	}

	/**
	 * Gets the password strategy to use for this model
	 * @return APasswordStrategy|boolean the password strategy, or false if none are configured
	 */
	public function getStrategy()
	{
		$owner = $this->getOwner(); /* @var CActiveRecord $owner */
		$strategyName = $owner->{$this->strategyAttribute};
		if (isset($this->_strategies[$strategyName])) {
			return $this->_strategies[$strategyName];
		}
		return $this->getDefaultStrategy();
	}

	/**
	 * Compares the given password to the stored password for this model
	 * @param string $password the plain text password to check
	 * @return boolean true if the password matches, otherwise false
	 */
	public function verifyPassword($password)
	{
		$owner = $this->getOwner(); /* @var CActiveRecord $owner */
		$strategy = $this->getStrategy();
		if ($strategy === false) {
			return false; // no strategy
		}
		if ($this->saltAttribute) {
			$strategy->setSalt($owner->{$this->saltAttribute});
		}
		if (!$strategy->compare($password,$owner->{$this->passwordAttribute})) {
			return false;
		}
		if ($this->autoUpgrade && $strategy->name != $this->defaultStrategyName) {
			if (!$this->changePassword($password,!$strategy->canUpgradeTo($this->getDefaultStrategy()))) {
				// couldn't upgrade their password, so ask them for a new password
				$owner->saveAttributes(array(
					$this->requireNewPasswordAttribute => true
				));
			}
		}
		return true;
	}

	/**
	 * Changes the user's password and saves the record
	 * @param string $password the plain text password to change to
	 * @param boolean $runValidation whether to run validation or not
	 * @return boolean true if the password was changed successfully
	 */
	public function changePassword($password, $runValidation = true)
	{
		$owner = $this->getOwner(); /* @var CActiveRecord $owner */
		$this->changePasswordInternal($password);
		return $owner->save($runValidation);
	}

	/**
	 * Generates a password reset code to use for this user.
	 * This code can only be used once.
	 * @return string the password reset code
	 */
	public function getPasswordResetCode()
	{
		$owner = $this->getOwner(); /* @var CActiveRecord $owner */
		$salt = $this->saltAttribute ? $owner->{$this->saltAttribute} : false;
		$password = $owner->{$this->passwordAttribute};
		return sha1("ResetPassword:".$owner->getPrimaryKey().":".$salt.":".$password);
	}

	/**
	 * Changes the user's password but doesn't perform any saving
	 * @param string $password the password to change to
	 */
	protected function changePasswordInternal($password)
	{
		$owner = $this->getOwner(); /* @var CActiveRecord $owner */
		if ($this->autoUpgrade) {
			$strategy = $this->getDefaultStrategy();
		}
		else {
			$strategy = $this->getStrategy();
		}
		$salt = $strategy->getSalt(true);
		if ($this->saltAttribute && $salt !== false) {
			$owner->{$this->saltAttribute} = $salt;
		}
		$owner->{$this->strategyAttribute} = $strategy->name;
		$this->_hashedPassword = $owner->{$this->passwordAttribute} = $strategy->encode($password);
	}

	/**
	 * Invoked after the model is found, stores the hashed user password
	 * @param CModelEvent $event the raised event
	 */
	public function afterFind($event)
	{
		$this->_hashedPassword = $event->sender->{$this->passwordAttribute};
	}

	/**
	 * Invoked before the model is saved, re hashes the password if required
	 * @param CModelEvent $event the raised event
	 */
	public function beforeSave($event)
	{
		$password = $event->sender->{$this->passwordAttribute};
		if ($password != $this->_hashedPassword && $password != "") {
			$this->changePasswordInternal($password);
		}
		elseif ($password == "" && $this->_hashedPassword != "") {
			$event->sender->{$this->passwordAttribute} = $this->_hashedPassword;
		}
	}
	/**
	 * Invoked before the model is validated.
	 * Validates the password first
	 * @param CModelEvent $event the raised event
	 */
	public function beforeValidate($event)
	{
		$password = $event->sender->{$this->passwordAttribute};
		$strategy = $this->getStrategy();
		if ($strategy !== false && $password != $this->_hashedPassword && $password != "") {
			$strategy->attributes = array($this->passwordAttribute);
			$strategy->validate($event->sender);
		}
		return parent::beforeValidate($event);
	}
}
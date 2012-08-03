<?php
/**
 * A base class for password strategies.
 *
 * Password strategies encapsulate the logic for encoding and verifying user supplied passwords,
 * as well as specifiying their minimum complexity.
 *
 * Password strategies allow authentication methods to be changed and upgraded
 * progressively without affecting the user experience.
 *
 * @package packages.passwordStrategy
 * @author Charles Pick
 */
abstract class APasswordStrategy extends CValidator {

	/**
	 * The name of this password strategy
	 * @var string
	 */
	public $name;

	/**
	 * The number of days a password is valid for before it should be changed.
	 * Defaults to false, meaning passwords do not expire
	 * @var integer|boolean
	 */
	public $daysValid = false;

	/**
	 * The minimum password length
	 * @var integer
	 */
	public $minLength = 6;

	/**
	 * The maximum password length.
	 * There is no good reason to set this value unless you're using it for legacy authentication
	 * Defaults to false meaning no maximum password length.
	 * @var integer|boolean
	 */
	public $maxLength = false;

	/**
	 * The minimum number of upper case letters that should appear in passwords.
	 * Defaults to 0 meaning no minimum.
	 * @var integer
	 */
	public $minUpperCaseLetters = 0;

	/**
	 * The minimum number of lower case letters that should appear in passwords.
	 * Defaults to 0 meaning no minimum.
	 * @var integer
	 */
	public $minLowerCaseLetters = 0;

	/**
	 * The minimum number of digits that should appear in passwords.
	 * Defaults to 0 meaning no minimum.
	 * @var integer
	 */
	public $minDigits = 0;

	/**
	 * The minimum number of special characters that should appear in passwords.
	 * Defaults to 0 meaning no minimum.
	 * @var integer
	 */
	public $minSpecialCharacters = 0;

	/**
	 * The special characters that should appear in passwords if $minSpecialCharacters is set
	 * @var array
	 */
	public $specialCharacters = array(" ","'","~","!","@","#","£","$","%","^","&","\*","(",")","_","-","\+","=","[","]","\\","\|","{","}",";",":",'"',"\.",",","\/","<",">","\?","`");
	/**
	 * @var string the salt to use for this password, if supported by this strategy
	 */
	private $_salt;

	/**
	 * Sets the salt to use with this strategy, if supported
	 * @param string $salt the salt
	 */
	public function setSalt($salt)
	{
		$this->_salt = $salt;
	}

	/**
	 * Gets the salt to use with this strategy, if supported.
	 * @param boolean $forceRefresh whether to force generate a new salt
	 * @return string the generated salt
	 */
	public function getSalt($forceRefresh = false)
	{
		if ($this->_salt === null || $forceRefresh) {
			$this->_salt = $this->generateSalt();
		}
		return $this->_salt;
	}

	/**
	 * Generates a random salt.
	 * @return string|boolean the generated salt, or false if not supported by this strategy
	 */
	protected function generateSalt() {
		return false;
	}

	/**
	 * Validates a new password to ensure that it meets the minimum complexity requirements
	 * @param CModel $object the data object being validated
	 * @param string $attribute the name of the attribute to be validated.
	 * @return boolean true if validation succeeded
	 */
	protected function validateAttribute($object, $attribute)
	{
		$password = $object->{$attribute};
		$length = mb_strlen($password);
		if ($this->minLength && $length < $this->minLength) {
			$this->addError($object,$attribute,"{attribute} is too short, minimum is ".$this->minLength." characters.");
			return false;
		}
		if ($this->maxLength && $length > $this->maxLength) {
			$this->addError($object,$attribute,"{attribute} is too long, maximum is ".$this->maxLength." characters.");
			return false;
		}
		if ($this->minDigits) {
			$digits = "";
			if (preg_match_all("/[\d+]/u",$password,$matches)) {
				$digits = implode("",$matches[0]);
			}
			if (mb_strlen($digits) < $this->minDigits) {
				$this->addError($object,$attribute,"{attribute} should contain at least ".$this->minDigits." ".($this->minDigits == 1 ? "digit" : "digits"));
				return false;
			}
		}
		if ($this->minUpperCaseLetters) {
			$upper = "";
			if (preg_match_all("/[A-Z]/u",$password,$matches)) {
				$upper = implode("",$matches[0]);
			}
			if (mb_strlen($upper) < $this->minUpperCaseLetters) {
				$this->addError($object,$attribute,"{attribute} should contain at least ".$this->minUpperCaseLetters." upper case ".($this->minUpperCaseLetters == 1 ? "character" : "characters"));
				return false;
			}
		}
		if ($this->minLowerCaseLetters) {
			$lower = "";
			if (preg_match_all("/[a-z]/u",$password,$matches)) {
				$lower = implode("",$matches[0]);
			}
			if (mb_strlen($lower) < $this->minLowerCaseLetters) {
				$this->addError($object,$attribute,"{attribute} should contain at least ".$this->minLowerCaseLetters." lower case ".($this->minLowerCaseLetters == 1 ? "character" : "characters"));
				return false;
			}
		}
		if ($this->minSpecialCharacters) {
			$special = "";
			if (preg_match_all("/[".implode("|",$this->specialCharacters)."]/u",$password,$matches)) {
				$special = implode("",$matches[0]);
			}
			if (mb_strlen($special) < $this->minSpecialCharacters) {
				$this->addError($object,$attribute,"{attribute} should contain at least ".$this->minSpecialCharacters." non alpha numeric ".($this->minSpecialCharacters == 1 ? "character" : "characters"));
				return false;
			}
		}
		return true;
	}
	/**
	 * Encode a plain text password.
	 * Child classes should implement this method and do their encoding here
	 * @param string $password the plain text password to encode
	 * @return string the encoded password
	 */
	abstract public function encode($password);

	/**
	 * Compare a plain text password to the given encoded password
	 * @param string $password the plain text password to compare
	 * @param string $encoded the encoded password to compare to
	 * @return boolean true if the passwords are equal, otherwise false
	 */
	public function compare($password, $encoded) {
		$hash = $this->encode($password);
		return $hash == $encoded;
	}

	/**
	 * Checks whether this strategy can be upgraded to another given strategy.
	 * If this strategy's complexity requirements are equal or greater than that
	 * of the given strategy, then it can be upgraded. Otherwise the user must be
	 * prompted to enter a new password that meets the complexity requirements.
	 * @param APasswordStrategy $strategy the strategy to upgrade to
	 * @return boolean true if this strategy can be upgraded to the given strategy
	 */
	public function canUpgradeTo(APasswordStrategy $strategy) {
		if ($strategy->minLength && $strategy->minLength > $this->minLength) {
			return false;
		}
		if ($strategy->minDigits > $this->minDigits) {
			return false;
		}
		if ($strategy->minLowerCaseLetters > $this->minLowerCaseLetters) {
			return false;
		}
		if ($strategy->minUpperCaseLetters > $this->minUpperCaseLetters) {
			return false;
		}
		if ($strategy->minSpecialCharacters > $this->minSpecialCharacters) {
			return false;
		}
		return true;
	}
}
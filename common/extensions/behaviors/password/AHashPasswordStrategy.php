<?php
/**
 * A password strategy based on multiple rounds of hashes.
 * The default implementation encodes passwords using 100 rounds of sha1
 * @author Charles Pick
 * @package packages.passwordStrategy
 */
class AHashPasswordStrategy extends APasswordStrategy {

	/**
	 * The work factor used when hashing passwords.
	 * The higher the work factor the more computationally expensive
	 * it is to encode and validate passwords. So it makes your passwords
	 * harder to crack, but it can also be a burden on your own server.
	 *
	 * @var integer
	 */
	public $workFactor = 100;

	/**
	 * The hash method to use when encoding passwords
	 * @var Callable
	 */
	public $hashMethod = "sha1";

	/**
	 * Generates a random salt to use when noncing passwords
	 * @return string the random salt
	 */
	protected function generateSalt()
	{
		return call_user_func_array($this->hashMethod,array(uniqid("",true)));
	}

	/**
	 * Encode a plain text password.
	 * Child classes should implement this method and do their encoding here
	 * @param string $password the plain text password to encode
	 * @return string the encoded password
	 */
	public function encode($password)
	{
		$hash = $this->getSalt()."###".$password;
		for($i = 0; $i < $this->workFactor; $i++) {
			$hash = call_user_func_array($this->hashMethod,array($hash));
		}
		return $hash;
	}

}
<?php
/**
 * A password strategy that uses bcrypt.
 * The default implementation uses a work factor of 12, you should adjust
 * this based on your security requirements
 * @author Charles Pick
 * @package packages.passwordStrategy
 */
class ABcryptPasswordStrategy extends APasswordStrategy
{
	/**
	 * The work factor used when hashing passwords.
	 * The higher the work factor the more computationally expensive
	 * it is to encode and validate passwords. So it makes your passwords
	 * harder to crack, but it can also be a burden on your own server.
	 *
	 * @var integer
	 */
	public $workFactor = 12;
	/**
	 * Generates a random salt.
	 * @return string the generated salt
	 */
	protected function generateSalt()
	{
		$salt = '$2a$'.str_pad($this->workFactor,2,'0',STR_PAD_LEFT).'$';
		$salt .= substr(strtr(base64_encode($this->getRandomBytes(16)),'+','.'),0,22);
		return $salt;
	}
	/**
	 * Gets a number of random bytes
	 * @param integer $count the number of bytes to return
	 * @return bool|string
	 */
	protected function getRandomBytes($count = 16)
	{
		$bytes = "";
		if (function_exists("openssl_random_pseudo_bytes") && strtoupper(substr(PHP_OS,0,3)) !== "WIN") {
			$bytes = openssl_random_pseudo_bytes($count);
		}
		else if(
			$bytes == ""
			&& is_readable("/dev/urandom")
			&& ($handle = fopen("/dev/urandom", "rb")) !== false
		) {
			$bytes = fread($handle,$count);
			fclose($handle);
		}

		if (strlen($bytes) < $count) {
			$key = uniqid(Yii::app()->name, true);

			// we need to pad with some pseudo random bytes
			while(strlen($bytes) < $count) {
				$value = $bytes;
				for($i = 0; $i < 12; $i++) {
                    if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
                        $value = hash_hmac('sha1',microtime().$value,$key,true);
                    } else {
                        $value = hash_hmac('salsa20',microtime().$value,$key,true);
                    }
					usleep(10); // make sure microtime() returns a new value
				}
				$bytes = substr($value,0,$count);
			}
		}
		return $bytes;
	}

	/**
	 * Encode a plain text password.
	 * Child classes should implement this method and do their encoding here
	 * @param string $password the plain text password to encode
	 * @return string the encoded password
	 */
	public function encode($password)
	{
		return crypt($password,$this->getSalt());
	}

}
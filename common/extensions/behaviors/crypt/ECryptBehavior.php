<?php
/**
 * ECryptBehavior class
 *
 * Encrypts / Decrypts specific attributes with CSecurityManager
 *
 * @author Antonio Ramirez <antonio@ramirezcobos.com>
 *
 * How to use:
 *
 * On main.php config file
 *
 * 'securityManager'=>array(
 *      'cryptAlgorithm'=>array(
 *          'rijndael-128',
 *          '',
 *          'ecb',
 *          ''
 *      ),
 *  'encryptionKey'=>'mysecretkeygoeshere',
 * ),
 *
 * On your model
 *
 * public function behaviors()
 * {
 *      return array(
 *          'crypt'=>array(
 *          // this assumes that the behavior is in the folder: protected/behaviors/
 *          'class'=>'application.behaviors.ECryptBehavior',
 *          // this sets that the attributes to be encrypted/decrypted are encrypted fieldname of the model
 *          'attributes'=>array('clientSocialSecurity'),
 *          'useAESMySql'=>true
 *      ));
 * }
 *
 */
class ECryptBehavior extends CActiveRecordBehavior {

	public $attributes = array();
	public $useAESMySql = false;

	/**
	 * Encrypts the value of specified attributes before saving to database
	 * @param CEvent $event
	 * @return parent::beforeSave
	 */
	public function beforeSave($event)
	{

		foreach ($this->getOwner()->getAttributes() as $key => $value)
		{
			if (in_array($key, $this->attributes) && !empty($value))
			{
				if ($this->useAESMySql)
					$this->getOwner()->{$key} = $this->mysqlAESEncrypt($value, Yii::app()->securityManager->getEncryptionKey());
				else
					$this->getOwner()->{$key} = utf8_encode(Yii::app()->securityManager->encrypt($value));
			}
		}
		return parent::beforeSave($event);
	}

	/**
	 * Decripts the values of specified attributes after finding from database
	 * @param CEvent $event
	 * @return parent::afterFind
	 */
	public function afterFind($event)
	{
		foreach ($this->getOwner()->getAttributes() as $key => $value)
		{
			if (in_array($key, $this->attributes) && !empty($value))
			{
				if ($this->useAESMySql)
					$this->getOwner()->{$key} = $this->mysqlAESDecrypt($value, Yii::app()->securityManager->getEncryptionKey());
				else
					$this->getOwner()->{$key} = Yii::app()->securityManager->decrypt(utf8_decode($value));
			}
		}
		return parent::afterFind($event);
	}

	/**
	 * MySQL compliant functions
	 *
	 * @param string $val the value to decrypt
	 * @param string $ky the key
	 * @return string the values decrypted
	 */
	public function mysqlAESDecrypt($val, $ky)
	{
		$key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
		for ($a = 0; $a < strlen($ky); $a++)
			$key[$a % 16] = chr(ord($key[$a % 16]) ^ ord($ky[$a]));
		$mode = MCRYPT_MODE_ECB;
		$enc = MCRYPT_RIJNdael_128;
		$dec = @mcrypt_decrypt($enc, $key, $val, $mode, @mcrypt_create_iv(@mcrypt_get_iv_size($enc, $mode), MCRYPT_DEV_URANDOM));
		return rtrim($dec, (( ord(substr($dec, strlen($dec) - 1, 1)) >= 0 and ord(substr($dec, strlen($dec) - 1, 1)) <= 16) ? chr(ord(substr($dec, strlen($dec) - 1, 1))) : null));
	}
	/**
	 * MySQL compliant functions
	 *
	 * @param string $val the value to encrypt
	 * @param string $ky the key
	 * @return string the values encrypted    */
	public function mysqlAESEncrypt($val, $ky)
	{
		$key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
		for ($a = 0; $a < strlen($ky); $a++)
			$key[$a % 16] = chr(ord($key[$a % 16]) ^ ord($ky[$a]));
		$mode = MCRYPT_MODE_ECB;
		$enc = MCRYPT_RIJNdael_128;
		$val = str_pad($val, (16 * (floor(strlen($val) / 16) + (strlen($val) % 16 == 0 ? 2 : 1))), chr(16 - (strlen($val) % 16)));
		return @mcrypt_encrypt($enc, $key, $val, $mode, mcrypt_create_iv(mcrypt_get_iv_size($enc, $mode), MCRYPT_DEV_URANDOM));
	}

}
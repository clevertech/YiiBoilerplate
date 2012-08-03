<?php
/**
 * User.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 11:42 PM
 */
/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $username
 * @property string $login_ip
 * @property integer $login_attempts
 * @property integer $login_time
 * @property string $validation_key
 * @property integer $create_id
 * @property integer $create_time
 * @property integer $update_id
 * @property integer $update_time
 * @property integer $delete_id
 * @property integer $delete_time
 * @property integer $status
 */
class User extends CActiveRecord {

	/**
	 * @var string attribute used for new passwords on user's edition
	 */
	public $newPassword;

	/**
	 * @var string attribute used to confirmation fields
	 */
	public $passwordConfirm;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Customer the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{user}}';
	}

	/**
	 * Behaviors
	 * @return array
	 */
	public function behaviors() {
		return array(
			// Password behavior strategy
			"APasswordBehavior" => array(
				"class" => "APasswordBehavior",
				"defaultStrategyName" => "bcrypt",
				"strategies" => array(
					"bcrypt" => array(
						"class" => "ABcryptPasswordStrategy",
						"workFactor" => 14,
						"minLength" => 8
					),
					"legacy" => array(
						"class" => "ALegacyMd5PasswordStrategy",
						'minLength' => 8
					)
				),
			)
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, surname, email', 'required', 'on' => 'checkout'),
			array('email', 'unique', 'on' => 'checkout', 'message' => Yii::t('validation', 'Email has already been taken.')),
			array('email', 'email'),
			array('username, email', 'unique'),
			array('passwordConfirm', 'compare', 'compareAttribute' => 'newPassword', 'message' => Yii::t('validation', "Passwords don't match")),
			array('newPassword, password_strategy', 'length', 'max' => 50, 'min' => 8),
			array('name, surname, password', 'length', 'max' => 45),
			array('email, password, salt', 'length', 'max' => 125),
			array('requires_new_password, login_attempts', 'numerical', 'integerOnly'=> true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, surname, password, salt, password_strategy, requires_new_password, email', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'creditCard' => array(self::HAS_MANY, 'BillingInfo', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'username' => Yii::t('labels', 'Username'),
			'name' => Yii::t('labels', 'Name'),
			'surname' => Yii::t('labels', 'Surname'),
			'password' => Yii::t('labels', 'Password'),
			'newPassword' => Yii::t('labels', 'Password'),
			'passwordConfirm' => Yii::t('labels', 'Confirm password'),
			'email' => Yii::t('labels', 'Email'),
		);
	}

	/**
	 * Helper property function
	 * @return string the full name of the customer
	 */
	public function getFullName() {

		return ucwords($this->name . ' ' . $this->surname);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('surname', $this->surname, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('email', $this->email, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Makes sure usernames are lowercase
	 * (emails by standard can have uppercase letters)
	 * @return parent::beforeValidate
	 */
	public function beforeValidate() {
		if (!empty($this->username))
			$this->username = strtolower($this->username);
		return parent::beforeValidate();
	}

	/**
	 * Generates a new validation key (additional security for cookie)
	 */
	public function regenerateValidationKey() {
		$this->saveAttributes(array(
			'validation_key' => md5(mt_rand() . mt_rand() . mt_rand()),
		));
	}

}
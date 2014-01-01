<?php
/**
 * Model class for login form at backend
 *
 * This form is almost default implementation of the login from the Yii tutorials.
 * Captcha was added and the code to limit max number of failed login attempts.
 *
 * @package YiiBoilerplate\Backend
 */
class BackendLoginForm extends CFormModel
{
    /**
     * Max number of allowed failed login attempts before we show captcha.
     *
     * @var int
     */
    const MAX_LOGIN_ATTEMPTS = 3;

    /**
     * User name
     *
     * @var string
     */
	public $username;

    /**
     * User password
     *
     * @var string
     */
	public $password;

    /**
     * Whether to login user for some amount of time or until end of session.
     *
     * @var bool
     */
	public $rememberMe;

    /**
     * Captcha code
     *
     * @var string
     */
	public $verifyCode;

    /** @var CUserIdentity */
	private $_identity;

    /** @var User */
	private $_user = null;

	/**
	 * Validation rules
     *
     * @see CModel::rules()
     *
	 * @return array
	 */
	public function rules()
    {
		return array(
			array('password, username', 'required'),
			array('verifyCode', 'validateCaptcha'),
			array('password', 'authenticate'),
			array('rememberMe', 'boolean'),
		);
	}

	/**
	 * Returns attribute labels
     *
     * @see CModel::attributeLabels()
     *
	 * @return array
	 */
	public function attributeLabels()
    {
		return array(
			'username' => Yii::t('labels', 'Username or e-mail'),
			'rememberMe' => Yii::t('labels', 'Remember me next time'),
		);
	}

	/**
	 * Inline validator for password field.
     *
	 * @param string
     * @param array
	 */
	public function authenticate($attribute, $params)
    {
        if ($this->hasErrors())
            return;

        $this->_identity = new AdminIdentity($this->username, $this->password);
        if ($this->_identity->authenticate())
            return;

        if ($this->user !== null and $this->user->login_attempts < 100)
            $this->user->saveAttributes(array('login_attempts' => $this->user->login_attempts + 1));

        $this->addError('username', Yii::t('errors', 'Incorrect username and/or password.'));
        $this->addError('password', Yii::t('errors', 'Incorrect username and/or password.'));
	}

	/**
	 * Inline validator for captcha code
     *
	 * @param string
	 * @param array
	 */
	public function validateCaptcha($attribute, $params)
    {
		if ($this->isCaptchaRequired())
			CValidator::createValidator('captcha', $this, $attribute, $params)->validate($this);
	}

	/**
	 * Login
     *
	 * @return bool
	 */
	public function login()
    {
		if ($this->_identity === null) {
			$this->_identity = new AdminIdentity($this->username, $this->password);
			$this->_identity->authenticate();
		}

		if ($this->_identity->isAuthenticated)
        {
			$duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			return true;
		}

        return false;
	}

	/**
     * Caching getter for user model associated with given username.
     *
	 * @return User
	 */
	public function getUser()
    {
		if ($this->_user === null)
			$this->_user = User::model()->findByAttributes(['username' => $this->username]);

		return $this->_user;
	}

	/**
	 * Returns whether it requires captcha or not
	 * @return bool
	 */
	public function isCaptchaRequired()
    {
		return ($user = $this->user) !== null && $user->login_attempts >= self::MAX_LOGIN_ATTEMPTS;
	}

}

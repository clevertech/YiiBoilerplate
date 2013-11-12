<?php
/**
 * SiteController.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/24/12
 * Time: 1:21 AM
 */

class BackendSiteController extends BackendController
{
	/**
     * Enabling the registration and other basic pages for guest users.
	 * @return array rules for the "accessControl" filter.
	 */
	public function accessRules()
	{
        return array_merge(
            array(
                array(
                    'allow', // Allow registration form for anyone
                    'actions' => array('index', 'login', 'logout', 'contact', 'captcha', 'error', 'test'),
                )
            ),
            parent::accessRules()
        );
	}

	/**
	 * @return array actions
	 */
	public function actions()
	{
		return array(
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
				'foreColor' => 0x0099CC,
			),
			'page' => array(
				'class' => 'CViewAction',
			),
            'error' => array(
                'class' => 'SimpleErrorAction'
            )
		);
	}

	/**
	 * Renders index page
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Action to render login form or handle user's login
	 * and redirection
	 */
	public function actionLogin()
	{
		if(!user()->isGuest) {
			$this->redirect('/');
		}
		$model = new LoginForm();

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
		{
			echo CActiveForm::validate($model, array('username', 'password', 'verifyCode'));
			Yii::app()->end();
		}

		if (isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			if ($model->validate(array('username', 'password', 'verifyCode')) && $model->login()) {
				$this->redirect(user()->returnUrl);
			}
		}

		$sent = r()->getParam('sent', 0);
		$this->render('login', array(
			'model' => $model,
			'sent' => $sent,
		));
	}

	/**
	 * This is the action that handles user's logout
	 */
	public function actionLogout()
	{
		user()->logout();
		$this->redirect(app()->homeUrl);
	}

}

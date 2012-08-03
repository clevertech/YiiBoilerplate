<?php
/**
 * SiteController.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/24/12
 * Time: 1:21 AM
 */

class SiteController extends Controller {
	/**
	 * @return array list of action filters (See CController::filter)
	 */
	public function filters() {
		return array('accessControl');
	}

	/**
	 * @return array rules for the "accessControl" filter.
	 */
	public function accessRules() {
		return array(
			array('allow', // Allow registration form for anyone
				'actions' => array('index', 'login', 'logout', 'recover', 'captcha', 'error', 'test'),
			),
			array('allow', // Allow all actions for logged in users ("@")
				'users' => array('@'),
			),
			array('deny'), // Deny anything else
		);
	}

	/**
	 *
	 * @return array actions
	 */
	public function actions() {
		return array(
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
				'foreColor' => 0x0099CC,
			),
			'page' => array(
				'class' => 'CViewAction',
			),
		);
	}

	/**
	 * Renders index page
	 */
	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * Action to render the error
	 * todo: design proper error page
	 */
	public function actionError() {
		if ($error = app()->errorHandler->error) {
			if (app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Action to render login form or handle user's login
	 * and redirection
	 */
	public function actionLogin() {
		$model = new LoginForm();

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model, array('username', 'password', 'verifyCode'));
			Yii::app()->end();
		}

		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			if ($model->validate(array('username', 'password', 'verifyCode')) && $model->login())
				$this->redirect(user()->returnUrl);
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
	public function actionLogout() {
		user()->logout();
		$this->redirect(app()->homeUrl);
	}

}
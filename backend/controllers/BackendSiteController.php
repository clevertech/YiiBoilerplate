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
			'page' => 'CViewAction',
            'error' => 'SimpleErrorAction',
            'login' => 'PasswordLoginAction',
            'logout' => 'LogoutAction',
            'index' => 'BackendHomePageAction'
		);
	}

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
                    'actions' => array('index', 'login', 'logout', 'captcha', 'error'),
                )
            ),
            parent::accessRules()
        );
	}

	/**
	 * Renders index page
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

}

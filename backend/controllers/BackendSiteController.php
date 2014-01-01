<?php
/**
 * Default controller for the backend entry point.
 *
 * For convenience we have all login-related stuff here, along with landing page, error page and static pages renderer.
 *
 * @package YiiBoilerplate\Backend
 */
class BackendSiteController extends BackendController
{
	/**
     * The actions defined in separate action classes and bound to this class by IDs.
     *
     * @see http://www.yiiframework.com/doc/api/1.1/CController#actions-detail
     *
	 * @return array
	 */
	public function actions()
	{
		return [
			'captcha' => [
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
				'foreColor' => 0x0099CC,
			],
			'page' => 'CViewAction',
            'error' => 'SimpleErrorAction',
            'login' => 'PasswordLoginAction',
            'logout' => 'LogoutAction',
            'index' => 'BackendHomePageAction'
		];
	}

	/**
     * Rules for CAccessControlFilter.
     *
     * We enable the registration and other basic pages for guest users.
     *
     * @see http://www.yiiframework.com/doc/api/1.1/CController#accessRules-detail
     *
	 * @return array Rules for the "accessControl" filter.
	 */
	public function accessRules()
	{
        return array_merge(
            [
                [ 'allow', 'actions' => ['index', 'login', 'logout', 'captcha', 'error'] ]
            ],
            parent::accessRules()
        );
	}
}

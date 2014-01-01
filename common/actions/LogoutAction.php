<?php
/**
 * Common behavior related to the user logging out of system.
 *
 * It's used in backend currently, but most possibly it'll be needed in frontend, too.
 *
 * @package YiiBoilerplate\Actions
 */
class LogoutAction extends CAction
{
    /**
     * On calling the logout action we do the logout by means of Yii auth mechanics and redirect to home URL.
     */
    public function run()
    {
        $user = Yii::app()->user;
        $user->logout();

        $url = Yii::app()->homeUrl;
        $this->controller->redirect($url);
    }
}
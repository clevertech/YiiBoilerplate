<?php
/** hijarian @ 12.11.13 15:45 */

class LogoutAction extends CAction
{
    public function run()
    {
        $user = Yii::app()->user;
        $user->logout();

        $url = Yii::app()->homeUrl;
        $this->controller->redirect($url);
    }
}
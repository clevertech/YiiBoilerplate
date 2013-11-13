<?php
/** hijarian @ 12.11.13 15:44 */

class PasswordLoginAction extends CAction
{
    public function run()
    {
        $user = Yii::app()->user;

        if (!$user->isGuest)
            $this->controller->redirect('/');

        $model = new LoginForm();

        $request = Yii::app()->request;

        $this->respondIfAjaxRequest($request, $model);

        $formData = $request->getPost(get_class($model), false);

        if ($formData)
        {
            $model->attributes = $formData;
            if ($model->validate(array('username', 'password', 'verifyCode')) && $model->login())
                $this->controller->redirect($user->returnUrl);
        }

        $sent = $request->getParam('sent', 0);
        $this->controller->render('login', compact( 'model', 'sent' ));
    }

    /**
     * @param CHttpRequest $request
     * @param User $model
     */
    private function respondIfAjaxRequest($request, $model)
    {
        $ajaxRequest = $request->getPost('ajax', false);
        if ($ajaxRequest and $ajaxRequest === 'login-form') {
            echo CActiveForm::validate(
                $model,
                array('username', 'password', 'verifyCode')
            );
            Yii::app()->end();
        }
    }
} 
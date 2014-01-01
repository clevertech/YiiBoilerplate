<?php
/**
 * Controller action for logging users in using the login form containing username and password.
 *
 * It is statically dependent on the LoginForm model representing the authentication form.
 *
 * @package YiiBoilerplate\Backend
 */
class PasswordLoginAction extends CAction
{
    /**
     * If there were no login attempt or it failed render login form page
     * otherwise redirect him to wherever he should return to.
     *
     * Also, this endpoint serves as the AJAX endpoint for client-side validation of login info.
     */
    public function run()
    {
        $user = Yii::app()->user;
        $this->redirectAwayAlreadyAuthenticatedUsers($user);

        $model = new BackendLoginForm();

        $request = Yii::app()->request;

        $this->respondIfAjaxRequest($request, $model);

        $formData = $request->getPost(get_class($model), false);

        if ($formData)
        {
            $model->attributes = $formData;
            if ($model->validate(array('username', 'password', 'verifyCode')) && $model->login())
                $this->controller->redirect($user->returnUrl);
        }

        $this->controller->render('login', compact('model'));
    }

    /**
     * @param CHttpRequest $request
     * @param User $model
     */
    private function respondIfAjaxRequest($request, $model)
    {
        $ajaxRequest = $request->getPost('ajax', false);
        if (!$ajaxRequest or $ajaxRequest !== 'login-form')
            return;

        echo CActiveForm::validate(
            $model,
            array('username', 'password', 'verifyCode')
        );
        Yii::app()->end();
    }

    /**
     * @param $user
     */
    private function redirectAwayAlreadyAuthenticatedUsers($user)
    {
        if (!$user->isGuest)
            $this->controller->redirect('/');
    }
} 
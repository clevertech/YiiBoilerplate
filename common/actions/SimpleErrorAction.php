<?php
/**
 * Generic action to display errors.
 *
 * Usable on both frontend and backend.
 * If the request was AJAX one, just output the message.
 * Otherwise, render error view.
 *
 * @package YiiBoilerplate\Actions
 */
class SimpleErrorAction extends CAction
{
    public function run()
    {
        $error = Yii::app()->errorHandler->error;
        if (!$error)
            return;

        if (Yii::app()->request->isAjaxRequest)
            echo $error['message'];
        else
            $this->controller->render('error', $error);
    }
}
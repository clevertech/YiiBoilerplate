<?php
/** hijarian @ 12.11.13 13:45 */

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
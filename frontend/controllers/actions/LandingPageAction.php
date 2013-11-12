<?php
/** hijarian @ 12.11.13 13:50 */

class LandingPageAction extends CAction
{
    public function run()
    {
        $this->controller->render('index');
    }
} 
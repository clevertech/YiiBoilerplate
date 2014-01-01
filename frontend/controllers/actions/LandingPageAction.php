<?php
/**
 * Most basic landing page rendering action possible.
 */
class LandingPageAction extends CAction
{
    public function run()
    {
        $this->controller->render('index');
    }
} 
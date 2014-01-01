<?php
/**
 * Controller action representing the act of home page rendering on backend.
 *
 * Everything which should be done when user opens the backend landing page is here.
 *
 * @package YiiBoilerplate\Backend
 */
class BackendHomePageAction extends CAction
{
    /**
     * We render the homepage as a controller action here.
     */
    public function run()
    {
        $this->controller->render('index');
    }
} 
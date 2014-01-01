<?php
/**
 * Base class for controllers at frontend.
 *
 * Includes all assets required for frontend and also registers Google Analytics widget if there's code specified.
 *
 * @package YiiBoilerplate\Frontend
 */
class FrontendController extends CController
{
    /**
     * What to do before rendering the view file.
     *
     * We include Google Analytics code if ID was specified and register the frontend assets.
     *
     * @param string $view
     * @return bool
     */
    public function beforeRender($view)
    {
        $result = parent::beforeRender($view);
        $this->addGoogleAnalyticsCode();
        $this->registerAssets();
        return $result;
    }

    private function addGoogleAnalyticsCode()
    {
        $gaid = @Yii::app()->params['google.analytics.id'];
        if ($gaid)
            $this->widget('frontend.widgets.GoogleAnalytics.GoogleAnalyticsWidget', compact('gaid'));
    }

    private function registerAssets()
    {
        $publisher = Yii::app()->assetManager;
        $libraries = $publisher->publish(ROOT_DIR.'/common/packages');

        $registry = Yii::app()->clientScript;
        $registry
            ->registerCssFile("{$libraries}/html5boilerplate/normalize.css")
            ->registerCssFile("{$libraries}/html5boilerplate/main.css")
            ->registerScriptFile("{$libraries}/modernizrjs/modernizr-2.6.2.min.js", CClientScript::POS_HEAD)
            ->registerScriptFile("{$libraries}/html5boilerplate/plugins.js", CClientScript::POS_END)
            ->registerScriptFile("{$libraries}/underscorejs/underscore-min.js", CClientScript::POS_END)
            ->registerScriptFile("{$libraries}/backbonejs/backbone-min.js", CClientScript::POS_END);

        $frontend = $publisher->publish(ROOT_DIR.'/frontend/packages');
        $registry
            ->registerCssFile("{$frontend}/main-ui/main.css")
            ->registerScriptFile("{$frontend}/main-ui/main.js", CClientScript::POS_END);
    }
}

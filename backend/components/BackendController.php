<?php
/**
 * Controller.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:55 AM
 */
class BackendController extends CController
{

	public $breadcrumbs = array();
	public $menu = array();

    public function filters()
    {
        return array(
            'accessControl',
            array('bootstrap.filters.BootstrapFilter - delete'),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // Allow all actions for logged in users ("@")
				'users' => array('@'),
			),
			array('deny'), // Deny anything else
		);
    }

    public function beforeRender($view)
    {
        $result = parent::beforeRender($view);
        $this->registerAssets();
        return $result;
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

        $backend = $publisher->publish(ROOT_DIR.'/backend/packages');
        $registry
            ->registerCssFile("{$backend}/main-ui/main.css")
            ->registerScriptFile("{$backend}/main-ui/main.js", CClientScript::POS_END);
    }
}

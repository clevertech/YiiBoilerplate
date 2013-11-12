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
}

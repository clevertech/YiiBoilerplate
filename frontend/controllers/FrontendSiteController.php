<?php

class FrontendSiteController extends FrontendController
{
	/**
	 * Declares class-based actions.
	 * @return array
	 */
	public function actions()
    {
		return array(
            'index' => array(
                'class' => 'LandingPageAction'
            ),
            'error' => array(
                'class' => 'SimpleErrorAction'
            )
		);
	}
}
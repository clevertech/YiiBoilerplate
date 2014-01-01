<?php
/**
 * Basic "kitchen sink" controller for frontend.
 * It was configured to be accessible by `/site` route, not the `/frontendSite` one!
 */
class FrontendSiteController extends FrontendController
{
	/**
     * Actions attached to this controller
     *
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
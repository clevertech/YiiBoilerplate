<?php

use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;


/**
 * You should uncomment following lines  when your Yii instance really will be in
 * `/common/lib/yii` directory.
 * And your test config will be in `/common/config/test.php` file.
 * Also uncomment the `useContext` invocation in the constructor.
 */
// require_once __DIR__.'/YiiContext.php';
// require_once __DIR__.'/../../common/lib/Yii/yiit.php';
// Yii::$enableIncludePath = false;
// Yii::createWebApplication(__DIR__.'/../../common/config/test.php');


class FeatureContext extends RawMinkContext {

	public function __construct(array $parameters) {
		$this->useContext('mink', new MinkContext($parameters));
// 		$this->useContext('yii', new YiiContext($parameters));
	}

	/**
     * @Then /^I should see modal popup$/
     */
	public function iShouldSeeModalPopup(){
		$session = $this->getSession();
		$page = $session->getPage();
		$modal = $page->find('css', '#modal');
		if ((!$modal) || (!$modal->isVisible())) {
			throw new Exception('Modal popup was not popped up!');
		}
	}

}

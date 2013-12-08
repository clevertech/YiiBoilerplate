<?php

use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;

class FeatureContext extends RawMinkContext
{

	public function __construct(array $parameters)
    {
		$this->useContext('mink', new MinkContext($parameters));
	}

    /**
     * Write your test step definitions here.
     */

}

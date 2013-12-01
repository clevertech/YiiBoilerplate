<?php

use Behat\Behat\Context\Step\Given,
    Behat\Behat\Context\Step\Then,
    Behat\Behat\Exception\PendingException;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\RawMinkContext;

class YiiContext extends RawMinkContext {

  protected $app;
  protected $fixtures = false;

  public function __construct() {
    $this->app = Yii::app();

    if (is_array($this->fixtures)) {
      $this->getFixtureManager()->load($this->fixtures);
    }
  }

  public function getApp() {
    return $this->app;
  }

  /**
   * PHP magic method.
   * This method is overridden so that named fixture data can be accessed like a normal property.
   * @param string $name the property name
   * @return mixed the property value
   */
  public function __get($name) {
    if (is_array($this->fixtures) && ($rows = $this->getFixtureManager()->getRows($name)) !== false) {
      return $rows;
    }
    else {
      throw new Exception("Unknown property '$name' for class '".get_class($this)."'.");
    }
  }

  /**
   * PHP magic method.
   * This method is overridden so that named fixture ActiveRecord instances can be accessed in terms of a method call.
   * @param string $name method name
   * @param string $params method parameters
   * @return mixed the property value
   */
  public function __call($name, $params) {
    if (is_array($this->fixtures) && isset($params[0]) && ($record = $this->getFixtureManager()->getRecord($name, $params[0])) !== false) {
      return $record;
    }
    else {
      throw new Exception("Unknown method '$name' for class '".get_class($this)."'.");
    }
  }

  /**
   * @return CDbFixtureManager the database fixture manager
   */
  public function getFixtureManager() {
    return $this->app->getComponent('fixture');
  }

  /**
   * @param string $name the fixture name (the key value in {@link fixtures}).
   * @return array the named fixture data
   */
  public function getFixtureData($name) {
    return $this->getFixtureManager()->getRows($name);
  }

  /**
   * @param string $name the fixture name (the key value in {@link fixtures}).
   * @param string $alias the alias of the fixture data row
   * @return CActiveRecord the ActiveRecord instance corresponding to the specified alias in the named fixture.
   * False is returned if there is no such fixture or the record cannot be found.
   */
  public function getFixtureRecord($name, $alias) {
    return $this->getFixtureManager()->getRecord($name, $alias);
  }

  /**
   * @Given /^I am on the homepage$/
   */
  public function iAmOnTheHomepage() {
    return new Given('I am on "/"');
  }

  /**
   * @Then /^I should be on the homepage$/
   */
  public function iShouldBeOnTheHomepage() {
    return new Then('I should be on "/"');
  }

  /**
   * @Given /^there is a "(?P<model>[^"]*)" with following details:$/
   */
  public function thereIsAWithFollowingDetails($model, TableNode $table) {
    $model = ucfirst($model);

    $hash = $table->getHash();
    foreach ($hash as $row) {
      $obj = new $model;
      $obj->attributes = $row;
      $obj->save();
    }
  }

  /**
   * @Then /^I should be on the page for "(?P<model>[^"]*)" with following details:$/
   */
  public function iShouldBeOnThePageForWithInIts($model, TableNode $table) {
    $model = ucfirst($model);
    $attribute = $table->getRow(0);
    $value = $table->getRow(1);
    $obj = $model::model()->findByAttributes(array($attribute[0] => $value[0]));

    if ($obj === null) {
      throw new CDbException(ucfirst($model).' with "'.$attribute.'" equals to "'.$value.'" not found');
    }

    $expected = Yii::app()->urlManager->createUrl(strtolower($model).'/view', array('id' => $obj->id));
    $this->assertPageAddress($expected);
  }

}

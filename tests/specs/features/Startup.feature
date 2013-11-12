Feature: Behat tests are run properly
	In order to test the Behat+Mink+Yii context setup
	As a developer
	I should be able to see if my trivial tests are successful

Scenario: Open website with headless scriptless browser
# This step is defined in Yii context, if it is passed, then Yii context is attached
	Given I am on the homepage
	Then I should see "Sign in"

@javascript
Scenario: Does
	Given I am on the homepage
	And I follow "Sign in"
# This step is defined in our context
	Then I should see modal popup


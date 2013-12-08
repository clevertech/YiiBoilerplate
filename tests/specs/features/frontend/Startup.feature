Feature: Behat tests are running properly in initial boilerplate
  In order to build the application using the initial boilerplate
  As a developer
  I should be able to see if my trivial tests are successful

Scenario: Open website with headless browser without Javascript support
  Given I am on "/"
  Then I should see "Hello Guest"

@javascript
Scenario: Open website with full-blown browser
  Given I am on "/"
  Then I should see "Hello Guest"



@reset-schema
Feature: Login

  @webapp
  Scenario: Login user
    Given the following user:
      | email          | username | plainPassword | enabled |
      | toto@gmail.com | toto     | toto          | true    |
    When I log in with valid credentials
    Then I should be logged in as "toto"

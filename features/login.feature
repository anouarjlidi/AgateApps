@reset-database
Feature: Login

    @webapp
    Scenario: Login user
        Given a user:
            | email          | username | password |
            | toto@gmail.com | toto     | toto     |
        And I am on "/fr/login"
        When I fill in "Nom d'utilisateur / Adresse e-mail" with "toto"
        And fill in "Mot de passe" with "toto"
        And I press "Connexion"
        Then I should be logged in as "toto"

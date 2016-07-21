<?php

namespace Context\Webapp;

use Behat\MinkExtension\Context\RawMinkContext;

class LoginContext extends RawMinkContext
{
    /**
     * @Given I am on host :name
     */
    public function iAmOnHost($host)
    {
        $url = 'http://'.$host.'/app_test.php/';
        $this->setMinkParameter('base_url', $url);
    }

    /**
     * @When /^I log in with valid credentials$/
     */
    public function iLogInWithValidCredentials()
    {
        $this->visitPath('/fr/login');

        $page = $this->getSession()->getPage();

        $page->fillField('Nom d\'utilisateur', 'toto');
        $page->fillField('Mot de passe', 'toto');

        $page->pressButton('Connexion');
    }

    /**
     * @Then /^I should be logged in as "([^"]+)"$/
     */
    public function iShouldBeLoggedInAs($username)
    {
        $this->visitPath('/fr/profile');

        $page = $this->getSession()->getPage();

        if (null === $page->findLink('Déconnexion [ '.$username.' ]')) {
            throw new \RuntimeException('Link with username '.$username.' not found.');
        }
    }
}

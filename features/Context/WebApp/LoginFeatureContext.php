<?php

namespace Context\WebApp;

use Behat\Mink\Exception\ElementHtmlException;
use Behat\MinkExtension\Context\RawMinkContext;

class LoginFeatureContext extends RawMinkContext
{
    /**
     * @Then /^I should be logged in as "([^"]+)"$/
     */
    public function iShouldBeLoggedInAs($username)
    {
        $this->visitPath('/fr/profile');

        $page = $this->getSession()->getPage();

        if (null === $page->findLink('Déconnexion [ '.$username.' ]')) {
            throw new ElementHtmlException(sprintf('User %s does not seem to be logged in', $username), $this->getSession(), $page);
        }
    }
}

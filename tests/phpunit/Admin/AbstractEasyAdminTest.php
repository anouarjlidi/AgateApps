<?php

namespace Tests\Admin;

use Tests\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class AbstractEasyAdminTest extends WebTestCase
{

    /**
     * Returns the entity name in the backend.
     *
     * @return string
     */
    abstract public function getEntityName();

    /**
     * Returns the list of fields you expect to see in the backend
     * @return array
     */
    abstract public function provideListingFields();

    // Todo: create automatic tests for the backend

    /**
     * {@inheritdoc}
     */
    protected static function createClient(array $options = array(), array $server = array())
    {
        if (!isset($server['HTTP_HOST'])) {
            $server['HTTP_HOST'] = 'back.esteren.dev';
        }
        return parent::createClient($options, $server);
    }

    public function testIndex()
    {
        $client = static::createClient();
        $this->addCookieToClient($client);

        $client->request('GET', '/admin/fr/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode(), print_r($client->getResponse()->headers->all(), true));

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('EasyAdmin', $crawler->filter('meta[name="generator"]')->attr('content'));
    }

    protected function addCookieToClient(Client $client, $role = 'ROLE_ADMIN')
    {
        $session = $client->getContainer()->get('session');
        $session->set('_security_main', serialize(new UsernamePasswordToken('admin', 'admin', 'main', array($role))));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    public function testListingFields()
    {
        $client = static::createClient();
        $this->addCookieToClient($client);

        $crawler = $client->request('GET', '/admin/?entity='.$this->getEntityName().'&action=list');

        $wishedColumns = $this->provideListingFields();

        $this->assertEquals(count($wishedColumns), $crawler->filter('#main table thead tr th[data-property-name]')->count());

        foreach ($wishedColumns as $columnName) {
            $this->assertEquals(1, $crawler->filter('#main table thead tr th[data-property-name="'.$columnName.'"]')->count(), 'Column '.$columnName.' in title.');
        }

        $count = $crawler->filter('#main table tr[data-id]')->count();

        if (0 === $count) {
            $this->markTestIncomplete('No data to test in the listing for the entity "'.$this->getEntityName().'"');
        }
    }

}

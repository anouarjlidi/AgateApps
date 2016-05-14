<?php

namespace Tests\Admin;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DomCrawler\Crawler;
use Tests\WebTestCase;

abstract class AbstractEasyAdminTest extends WebTestCase
{

    /**
     * Returns the entity name in the backend.
     *
     * @return string
     */
    abstract public function getEntityName();

    /**
     * The entity full qualified class name to be used when managing entities
     *
     * @return string
     */
    abstract public function getEntityClass();

    /**
     * Returns the list of fields you expect to see in the backend
     * @return array
     */
    abstract public function provideListingFields();

    // TODO: create automatic tests for the backend

    // TODO: Test page creation

    // TODO: Test page edition

    // TODO: Test page deletion

    public function testListingFields()
    {
        $client = $this->getClient();

        $crawler = $client->request('GET', '/fr/?entity='.$this->getEntityName().'&action=list');

        $wishedColumns = $this->provideListingFields();

        if (!$wishedColumns) {
            static::markTestSkipped('No columns to test the listing page.');
        }

        static::assertEquals(200, $client->getResponse()->getStatusCode());

        /** @var Crawler|\DOMElement[] $nodeHeaders */
        $nodeHeaders = $crawler->filter('#main table thead tr th[data-property-name]');

        static::assertCount(count($wishedColumns), $nodeHeaders);

        foreach ($nodeHeaders as $k => $node) {
            static::assertArrayHasKey($k, $wishedColumns);
            static::assertEquals($wishedColumns[$k], $node->getAttribute('data-property-name'));
        }

        foreach ($wishedColumns as $columnName) {
            static::assertEquals(1, $crawler->filter('#main table thead tr th[data-property-name="'.$columnName.'"]')->count(), 'Column '.$columnName.' in title.');
        }
    }

    public function testListingContents()
    {
        $client = $this->getClient();

        $crawler = $client->request('GET', '/fr/?entity='.$this->getEntityName().'&action=list');

        static::assertEquals(200, $client->getResponse()->getStatusCode());

        $count = $crawler->filter('#main table tr[data-id]')->count();

        if (0 === $count) {
            static::markTestSkipped('No data to test in the listing for the entity "'.$this->getEntityName().'"');
        }
    }

    /**
     * Overrides classic client behavior to be sure we have a client that points to the backend.
     *
     * @param string        $host
     * @param array         $options
     * @param array|string  $tokenRoles
     *
     * @return Client
     */
    protected function getClient($host = null, array $options = array(), $tokenRoles = array())
    {
        if (null === $host) {
            $host = 'back.esteren.dev';
        }
        if (0 === count($tokenRoles)) {
            $tokenRoles[] = 'ROLE_ADMIN';
        }
        return parent::getClient($host, $options, is_array($tokenRoles) ? $tokenRoles : [$tokenRoles]);
    }

}

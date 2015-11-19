<?php

namespace Tests\Admin;

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
        $client = static::getClient();

        $crawler = $client->request('GET', '/fr/?entity='.$this->getEntityName().'&action=list');

        $wishedColumns = $this->provideListingFields();

        if (!$wishedColumns) {
            $this->markTestSkipped('No columns to test the listing page.');
        }

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        /** @var Crawler $nodeHeaders */
        $nodeHeaders = $crawler->filter('#main table thead tr th[data-property-name]');

        $this->assertEquals(count($wishedColumns), $nodeHeaders->count());

        foreach ($nodeHeaders as $k => $node) {
            $this->assertArrayHasKey($k, $wishedColumns);
            $this->assertEquals($wishedColumns[$k], $node->getAttribute('data-property-name'));
        }

        foreach ($wishedColumns as $columnName) {
            $this->assertEquals(1, $crawler->filter('#main table thead tr th[data-property-name="'.$columnName.'"]')->count(), 'Column '.$columnName.' in title.');
        }
    }

    public function testListingContents()
    {
        $client = static::getClient();

        $crawler = $client->request('GET', '/fr/?entity='.$this->getEntityName().'&action=list');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $count = $crawler->filter('#main table tr[data-id]')->count();

        if (0 === $count) {
            $this->markTestSkipped('No data to test in the listing for the entity "'.$this->getEntityName().'"');
        }
    }

    /**
     * Overrides classic client behavior to be sure we have a client that points to the backend.
     *
     * {@inheritdoc}
     */
    protected function getClient($host = null, array $options = array(), $tokenRoles = array())
    {
        if (null === $host) {
            $host = 'back.esteren.dev';
        }
        if (empty($tokenRoles)) {
            $tokenRoles[] = 'ROLE_ADMIN';
        }
        return parent::getClient($host, $options, $tokenRoles);
    }

}

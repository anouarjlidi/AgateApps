<?php

namespace Tests\Admin;

use Doctrine\ORM\EntityManager;
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

    /**
     * A simple array of data to submit in the "new" form.
     * Keys of the array must correspond to the property field as specified in EasyAdmin config.
     *
     * @return array
     */
    abstract public function provideNewFormData();

    /**
     * A simple object to submit in the "edit" form.
     * Keys of the array must correspond to the property field as specified in EasyAdmin config.
     * Must specify an "id" attribute, else it will fail.
     * To be sure the test works, you might need to add fixtures with proper ID forced in the database.
     *
     * @return array
     */
    abstract public function provideEditFormData();

    /**
     * Provides an ID to test the "delete" action.
     * To be sure the test works, you might need to add fixtures with proper ID forced in the database.
     *
     * @return integer
     */
    abstract public function provideIdToDelete();

    public function testListingFields()
    {
        $client = $this->getClient();

        $crawler = $client->request('GET', '/fr/?entity='.$this->getEntityName().'&action=list');

        $wishedColumns = $this->provideListingFields();

        // False means that we do not ever want to test this feature.
        // Allows a cleaner phpunit output.
        if (false === $wishedColumns) {
            return;
        }

        if (!$wishedColumns) {
            static::markTestIncomplete('No columns to test the listing page.');
        }

        static::assertEquals(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        /** @var Crawler|\DOMElement[] $nodeHeaders */
        $nodeHeaders = $crawler->filter('#main table thead tr th[data-property-name]');

        static::assertCount(count($wishedColumns), $nodeHeaders, $this->getEntityName());

        foreach ($nodeHeaders as $k => $node) {
            static::assertArrayHasKey($k, $wishedColumns, $this->getEntityName());
            static::assertEquals($wishedColumns[$k], $node->getAttribute('data-property-name'), $this->getEntityName());
        }

        foreach ($wishedColumns as $columnName) {
            static::assertEquals(1, $crawler->filter('#main table thead tr th[data-property-name="'.$columnName.'"]')->count(), 'Column '.$columnName.' in title. ['.$this->getEntityName().']');
        }
    }

    public function testListingContentsIsNotEmpty()
    {
        $client = $this->getClient();

        $crawler = $client->request('GET', '/fr/?entity='.$this->getEntityName().'&action=list');

        static::assertEquals(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        $count = $crawler->filter('#main table tr[data-id]')->count();

        if (0 === $count) {
            static::markTestIncomplete('No data to test the "list" action for the entity "'.$this->getEntityName().'"');
        }
    }

    public function testNewAction()
    {
        $data = $this->provideNewFormData();

        // False means that we do not ever want to test this feature.
        // Allows a cleaner phpunit output.
        if (false === $data) {
            return;
        }

        if (!$data) {
            static::markTestIncomplete('No data to test the "new" action for entity "'.$this->getEntityName().'".');
        }

        $client = $this->getClient();

        $crawler = $client->request('GET', '/fr/?action=new&entity='.$this->getEntityName());

        static::assertEquals(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        $formEntityFieldName = strtolower($this->getEntityName());

        /** @var Crawler $formNode */
        $formNode = $crawler->filter('#new-'.$formEntityFieldName.'-form');

        static::assertEquals(1, $formNode->count(), $this->getEntityName());

        $form = $formNode->form();

        foreach ($data as $field => $value) {
            $form->get($formEntityFieldName.'['.$field.']')->setValue($value);
        }

        $crawler = $client->submit($form);
        // If redirects to list, it means it's correct, else it would redirect to "new" action.
        static::assertEquals(302, $client->getResponse()->getStatusCode(), $this->getEntityName());
        static::assertEquals('/fr/?action=list&entity='.$this->getEntityName(), $client->getResponse()->headers->get('location'), $this->getEntityName());

        $crawler->clear();
        $client->followRedirect();
        static::assertEquals(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        // Now, test that the last inserted entity corresponds.

        /** @var EntityManager $em */
        $em = $client->getContainer()->get('doctrine')->getManager();

        $lastEntity = $em
            ->getRepository($this->getEntityClass())
            ->createQueryBuilder('entity')
            ->orderBy('entity.id', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        foreach ($data as $field => $value) {
            if (method_exists($lastEntity, 'get'.ucfirst($field))) {
                static::assertEquals($value, $lastEntity->{'get'.ucfirst($field)}(), $this->getEntityName());
            }
        }
    }

    public function testEditAction()
    {
        $data = $this->provideEditFormData();

        // False means that we do not ever want to test this feature.
        // Allows a cleaner phpunit output.
        if (false === $data) {
            return;
        }

        if (!$data) {
            static::markTestIncomplete('No data to test the "edit" action for entity "'.$this->getEntityName().'".');
        }

        if (!array_key_exists('id', $data)) {
            static::fail('You must specify an ID in the "provideEditFormData" method.');
            return;
        }

        $client = $this->getClient();

        /** @var EntityManager $em */
        $em = $client->getContainer()->get('doctrine')->getManager();

        $crawler = $client->request('GET', '/fr/?action=edit&id='.$data['id'].'&entity='.$this->getEntityName());

        static::assertEquals(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        $formEntityFieldName = strtolower($this->getEntityName());

        /** @var Crawler $formNode */
        $formNode = $crawler->filter('#edit-'.$formEntityFieldName.'-form');

        static::assertEquals(1, $formNode->count(), $this->getEntityName());

        $form = $formNode->form();

        foreach ($data as $field => $value) {
            if ($field === 'id') {
                continue;
            }
            $form->get($formEntityFieldName.'['.$field.']')->setValue($value);
        }

        $crawler = $client->submit($form);
        // If redirects to list, it means it's correct, else it would redirect to "edit" action.
        static::assertEquals(302, $client->getResponse()->getStatusCode(), $this->getEntityName());
        static::assertEquals('/fr/?action=list&entity='.$this->getEntityName(), $client->getResponse()->headers->get('location'), $this->getEntityName());

        $crawler->clear();
        $client->followRedirect();
        static::assertEquals(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        // Now test the new entity corresponds
        $savedEntity = $em->find($this->getEntityClass(), $data['id']);

        foreach ($data as $field => $value) {
            if (method_exists($savedEntity, 'get'.ucfirst($field))) {
                static::assertEquals($value, $savedEntity->{'get'.ucfirst($field)}(), $this->getEntityName());
            }
        }
    }

    public function testDeleteAction()
    {
        $id = $this->provideIdToDelete();

        // False means that we do not ever want to test this feature.
        // Allows a cleaner phpunit output.
        if (false === $id) {
            return;
        }

        if (!$id) {
            static::markTestIncomplete('No data to test the "delete" action for entity "'.$this->getEntityName().'".');
        }

        $client = $this->getClient();

        // We'll make the DELETE request starting from the EDIT page.

        $crawler = $client->request('DELETE', '/fr/?action=edit&id='.$id.'&entity='.$this->getEntityName().'&referer=/');

        $deleteForm = $crawler->filter('#delete_form_submit');

        static::assertEquals(1, $deleteForm->count(), $this->getEntityName());

        $form = $deleteForm->form();

        $client->submit($form);

        // If redirects to list, it means it's correct, else it would redirect to "list" action.
        static::assertEquals(302, $client->getResponse()->getStatusCode(), $this->getEntityName());
        static::assertEquals('/', $client->getResponse()->headers->get('location'), $this->getEntityName());

        /** @var EntityManager $em */
        $em = $client->getContainer()->get('doctrine')->getManager();

        $object = $em->find($this->getEntityClass(), $id);

        if ($object && method_exists($object, 'getDeletedAt')) {
            // Ensure Gedmo Softdeletable works.
            static::assertNotNull($object->getDeletedAt());
        } else {
            static::assertFalse((bool) $object, $this->getEntityName());
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

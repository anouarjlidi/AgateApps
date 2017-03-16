<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\Tests;

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
     * The entity full qualified class name to be used when managing entities.
     *
     * @return string
     */
    abstract public function getEntityClass();

    /**
     * Returns the list of fields you expect to see in the backend.
     * Return "false" if you don't want to test native listing.
     *
     * @return array
     */
    abstract public function provideListingFields();

    /**
     * A simple array of data to submit in the "new" form.
     * Keys of the array must correspond to the property field as specified in EasyAdmin config.
     * Return "false" if you don't want to test "new" form.
     *
     * @return array
     */
    abstract public function provideNewFormData();

    /**
     * A simple object to submit in the "edit" form.
     * Keys of the array must correspond to the property field as specified in EasyAdmin config.
     * Must specify an "id" attribute, else it will fail.
     * To be sure the test works, you might need to add fixtures with proper ID forced in the database.
     * Return "false" if you don't want to test "edit" form.
     *
     * @return array
     */
    abstract public function provideEditFormData();

    /**
     * Provides an ID to test the "delete" action.
     * To be sure the test works, you might need to add fixtures with proper ID forced in the database.
     * Return "false" if you don't want to test "delete" form.
     *
     * @return integer
     */
    public function provideIdToDelete() {
        return false;
    }

    public function testListingFields()
    {
        $client = $this->getClient();

        $crawler = $client->request('GET', '/fr/?entity='.$this->getEntityName().'&action=list');

        $wishedColumns = $this->provideListingFields();

        // False means that we do not ever want to test this feature.
        // Allows a cleaner phpunit output.
        if (false === $wishedColumns) {
            static::assertTrue(true);
            return;
        }

        if (!$wishedColumns) {
            static::markTestIncomplete('No columns to test the listing page.');
        }

        static::assertSame(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        /** @var Crawler|\DOMElement[] $nodeHeaders */
        $nodeHeaders = $crawler->filter('#main table thead tr th[data-property-name]');

        static::assertCount(count($wishedColumns), $nodeHeaders, $this->getEntityName());

        foreach ($nodeHeaders as $k => $node) {
            static::assertArrayHasKey($k, $wishedColumns, $this->getEntityName());
            static::assertSame($wishedColumns[$k], $node->getAttribute('data-property-name'), $this->getEntityName());
        }

        foreach ($wishedColumns as $columnName) {
            static::assertSame(1, $crawler->filter('#main table thead tr th[data-property-name="'.$columnName.'"]')->count(), 'Column '.$columnName.' in title. ['.$this->getEntityName().']');
        }
    }

    public function testListingContentsIsNotEmpty()
    {
        $client = $this->getClient();

        $crawler = $client->request('GET', '/fr/?entity='.$this->getEntityName().'&action=list');

        static::assertSame(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        $count = $crawler->filter('#main table tr[data-id]')->count();

        if (0 === $count) {
            static::markTestIncomplete('No data to test the "list" action for the entity "'.$this->getEntityName().'"');
        }
    }

    public function testNewAction()
    {
        $expectedData = $this->provideNewFormData();

        // False means that we do not ever want to test this feature.
        // Allows a cleaner phpunit output.
        if (false === $expectedData) {
            static::assertTrue(true);
            return;
        }

        if (!$expectedData) {
            static::markTestIncomplete('No data to test the "new" action for entity "'.$this->getEntityName().'".');
        }

        $client = $this->getClient();

        $crawler = $client->request('GET', '/fr/?action=new&entity='.$this->getEntityName());

        static::assertSame(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        $formEntityFieldName = strtolower($this->getEntityName());

        /** @var Crawler $formNode */
        $formNode = $crawler->filter('#new-'.$formEntityFieldName.'-form');

        static::assertSame(1, $formNode->count(), $this->getEntityName());

        $form = $formNode->form();

        foreach ($expectedData as $field => $expectedValue) {
            $form->get($formEntityFieldName.'['.$field.']')->setValue($expectedValue);
        }

        $crawler = $client->submit($form);

        // If redirects to list, it means it's correct, else it would redirect to "new" action.
        static::assertSame(302, $client->getResponse()->getStatusCode(), 'Not redirecting when editing '.$this->getEntityName());
        static::assertSame('/fr/?action=list&entity='.$this->getEntityName(), $client->getResponse()->headers->get('location'), $this->getEntityName());

        $crawler->clear();
        $client->followRedirect();

        static::assertSame(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

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

        foreach ($expectedData as $field => $expectedValue) {
            $methodExists = false;
            $methodName = null;

            if (method_exists($lastEntity, 'get'.ucfirst($field))) {
                $methodExists = true;
                $methodName = 'get'.ucfirst($field);
            } elseif(method_exists($lastEntity, 'is'.ucfirst($field))) {
                $methodExists = true;
                $methodName = 'is'.ucfirst($field);
            } elseif(method_exists($lastEntity, 'has'.ucfirst($field))) {
                $methodExists = true;
                $methodName = 'has'.ucfirst($field);
            }

            if ($methodExists) {
                $valueToCompare = $lastEntity->$methodName();
                static::assertSame($expectedValue, $valueToCompare, 'Error for class property '.$this->getEntityName().'::$'.$field);
            } else {
                static::fail('Admin test for class property '.$this->getEntityName().'::$'.$field.' is incomplete because no getter exists...');
            }
        }
    }

    /**
     * @depends testNewAction
     */
    public function testEditAction()
    {
        $data = $this->provideEditFormData();

        // False means that we do not ever want to test this feature.
        // Allows a cleaner phpunit output.
        if (false === $data) {
            static::assertTrue(true);
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

        static::assertSame(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        $formEntityFieldName = strtolower($this->getEntityName());

        /** @var Crawler $formNode */
        $formNode = $crawler->filter('#edit-'.$formEntityFieldName.'-form');

        static::assertSame(1, $formNode->count(), $this->getEntityName());

        $form = $formNode->form();

        foreach ($data as $field => $value) {
            if ($field === 'id') {
                continue;
            }
            $form->get($formEntityFieldName.'['.$field.']')->setValue($value);
        }

        $crawler = $client->submit($form);
        // If redirects to list, it means it's correct, else it would redirect to "edit" action.
        static::assertSame(302, $client->getResponse()->getStatusCode(), $this->getEntityName());
        static::assertSame('/fr/?action=list&entity='.$this->getEntityName(), $client->getResponse()->headers->get('location'), $this->getEntityName());

        $crawler->clear();
        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode(), $this->getEntityName());

        // Now test the new entity corresponds
        $savedEntity = $em->find($this->getEntityClass(), $data['id']);

        foreach ($data as $field => $value) {
            if (method_exists($savedEntity, 'get'.ucfirst($field))) {
                static::assertSame($value, $savedEntity->{'get'.ucfirst($field)}(), $this->getEntityName());
            }
        }
    }

    /**
     * @depends testNewAction
     */
    public function testDeleteAction()
    {
        $id = $this->provideIdToDelete();

        // False means that we do not ever want to test this feature.
        // Allows a cleaner phpunit output.
        if (false === $id) {
            static::assertTrue(true);
            return;
        }

        if (!$id) {
            static::markTestIncomplete('No data to test the "delete" action for entity "'.$this->getEntityName().'".');
        }

        $client = $this->getClient();

        // We'll make the DELETE request starting from the EDIT page.

        $crawler = $client->request('DELETE', '/fr/?action=edit&id='.$id.'&entity='.$this->getEntityName().'&referer=/');

        $deleteForm = $crawler->filter('#delete_form_submit');

        static::assertSame(1, $deleteForm->count(), $this->getEntityName());

        $form = $deleteForm->form();

        $client->submit($form);

        // If redirects to list, it means it's correct, else it would redirect to "list" action.
        static::assertSame(302, $client->getResponse()->getStatusCode(), $this->getEntityName());
        static::assertSame('/', $client->getResponse()->headers->get('location'), $this->getEntityName());

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
     * @param string       $host
     * @param array        $kernelOptions
     * @param array|string $tokenRoles
     * @param array        $server
     *
     * @return Client
     */
    protected function getClient($host = null, array $kernelOptions = [], $tokenRoles = null, array $server = [])
    {
        if (null === $host) {
            $host = 'back.esteren.dev';
        }
        if (0 === count($tokenRoles)) {
            $tokenRoles[] = 'ROLE_ADMIN';
        }
        return parent::getClient($host, $kernelOptions, is_array($tokenRoles) ? $tokenRoles : [$tokenRoles]);
    }

}

<?php

namespace CorahnRin\CorahnRinBundle\Tests\Controller;

use CorahnRin\CorahnRinBundle\Entity\Characters;
use Tests\WebTestCase;

/**
 * @see CorahnRin\CorahnRinBundle\Controller\CharacterViewController
 */
class CharacterViewControllerTest extends WebTestCase
{

    /**
     * @see CharacterViewController::listAction
     */
    public function testList()
    {
        $client = $this->getClient('corahnrin.esteren.dev', array(), array('ROLE_MANAGER'));

        $crawler = $client->request('GET', '/fr/characters/');

        static::assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertEquals(1, $crawler->filter('table.table.table-condensed')->count());
    }

    /**
     * @see CharacterViewController::viewAction
     */
    public function testView404()
    {
        $client = $this->getClient('corahnrin.esteren.dev', array(), array('ROLE_MANAGER'));

        $client->request('GET', '/fr/characters/9999999-aaaaaaaa');

        static::assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @see CharacterViewController::viewAction
     */
    public function testView()
    {
        $client = $this->getClient('corahnrin.esteren.dev', array(), array('ROLE_MANAGER'));

        /**
         * @var Characters|null $char
         */
        $char = $client->getContainer()->get('doctrine')->getRepository('CorahnRinBundle:Characters')->find(608);

        if (!$char) {
            static::markTestSkipped('No character available in the database to test the route.');
        }

        $crawler = $client->request('GET', '/fr/characters/'.$char->getId().'-'.$char->getNameSlug());

        static::assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertEquals(1, $crawler->filter('h2.char-name')->count());
    }

}

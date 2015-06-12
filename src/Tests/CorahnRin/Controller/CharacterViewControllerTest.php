<?php

namespace Tests\CorahnRin\Controller;

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
        $client = static::getClient('corahnrin.esteren.dev');

        $crawler = $client->request('GET', '/fr/characters/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('table.table.table-condensed')->count());
    }

    /**
     * @see CharacterViewController::viewAction
     */
    public function testView404()
    {
        $client = static::getClient('corahnrin.esteren.dev');

        $client->request('GET', '/fr/characters/9999999-aaaaaaaa');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @see CharacterViewController::viewAction
     */
    public function testView()
    {
        $client = static::getClient('corahnrin.esteren.dev');

        /**
         * @var Characters|null $char
         */
        $char = $client->getContainer()->get('doctrine')->getRepository('CorahnRinBundle:Characters')->find(608);

        if (!$char) {
            $this->markTestSkipped('No character available in the database to test the route.');
        }

        $crawler = $client->request('GET', '/fr/characters/'.$char->getId().'-'.$char->getNameSlug());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('h2.char-name')->count());
    }

}

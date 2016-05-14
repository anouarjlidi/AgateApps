<?php

namespace Tests\CorahnRin\Controller;

use Tests\WebTestCase;

/**
 * @see CorahnRin\CorahnRinBundle\Controller\GeneratorController
 */
class GeneratorControllerTest extends WebTestCase
{
    /**
     * @see GeneratorController::indexAction
     */
    public function testIndex()
    {
        $client = $this->getClient('corahnrin.esteren.dev', array(), array('ROLE_MANAGER'));

        $client->request('GET', '/fr/characters/generate/');

        static::assertTrue($client->getResponse()->isRedirect('/fr/characters/generate/1-peuple'));
    }

    /**
     * @see GeneratorController::stepAction
     */
    public function testStep1()
    {
        $client = $this->getClient('corahnrin.esteren.dev', array(), array('ROLE_MANAGER'));

        $crawler = $client->request('GET', '/fr/characters/generate/1-peuple');

        static::assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertEquals(1, $crawler->filter('#gen-div-choice')->count());
        static::assertEquals(1, $crawler->filter('#generator_peuple')->count());
    }

    /**
     * @see GeneratorController::stepAction
     */
    public function testAllSteps()
    {
        $client = $this->getClient('corahnrin.esteren.dev');

        $client->request('GET', '/fr/characters/generate/1-peuple');

        static::markTestIncomplete('Need to generate unit tests for the whole 20-steps process... One day, maybe...');
    }

}

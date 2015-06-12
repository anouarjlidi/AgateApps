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
        $client = static::getClient('corahnrin.esteren.dev');

        $client->request('GET', '/fr/characters/generate/');

        $this->assertTrue($client->getResponse()->isRedirect('/fr/characters/generate/1-peuple'));
    }

    /**
     * @see GeneratorController::stepAction
     */
    public function testStep1()
    {
        $client = static::getClient('corahnrin.esteren.dev');

        $crawler = $client->request('GET', '/fr/characters/generate/1-peuple');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('#gen-div-choice')->count());
        $this->assertEquals(1, $crawler->filter('#generator_peuple')->count());
    }

    /**
     * @see GeneratorController::stepAction
     */
    public function testAllSteps()
    {
        $client = static::getClient('corahnrin.esteren.dev');

        $client->request('GET', '/fr/characters/generate/1-peuple');

        $this->markTestIncomplete('Need to generate unit tests for the whole 20-steps process... One day, maybe...');
    }

}

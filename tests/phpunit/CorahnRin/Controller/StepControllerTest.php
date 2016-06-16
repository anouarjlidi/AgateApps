<?php

namespace Tests\CorahnRin\Controller;

use Tests\WebTestCase;

/**
 * @see CorahnRin\CorahnRinBundle\Controller\GeneratorController
 */
class StepControllerTest extends WebTestCase
{
    /**
     * @see GeneratorController::indexAction
     */
    public function testIndex()
    {
        $client = $this->getClient('corahnrin.esteren.dev', array(), array('ROLE_MANAGER'));

        $client->request('GET', '/fr/character/generate');

        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate/people'), 'Could not check that generator index redirects to first step');
    }

    /**
     * @see GeneratorController::stepAction
     */
    public function testStep1()
    {
        $client = $this->getClient('corahnrin.esteren.dev', array(), array('ROLE_MANAGER'));

        $crawler = $client->request('GET', '/fr/character/generate/people');

        static::assertEquals(200, $client->getResponse()->getStatusCode(), 'Could not execute step 1 request...');
        // TODO
//        static::assertEquals(1, $crawler->filter('#gen-div-choice')->count());
//        static::assertEquals(1, $crawler->filter('#generator_people')->count());
    }

    /**
     * @see GeneratorController::stepAction
     */
    public function testAllSteps()
    {
        static::markTestIncomplete('Need to generate unit tests for the whole 20-steps process... One day, maybe...');
    }

}

<?php

namespace Tests\CorahnRin\Controller;

use Tests\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * @see CorahnRin\CorahnRinBundle\Controller\GeneratorController
 */
class StepControllerTest extends WebTestCase
{
    /**
     * @see StepController::indexAction
     */
    public function testIndex()
    {
        $client = $this->getClient('corahnrin.esteren.dev', array(), array('ROLE_MANAGER'));

        $client->request('GET', '/fr/character/generate');

        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate/people'), 'Could not check that generator index redirects to first step');
    }

    /**
     * @see StepController::stepAction
     */
    public function testAllSteps()
    {
        $client = $this->getClient('corahnrin.esteren.dev', array(), array('ROLE_MANAGER'));

        fwrite(STDOUT, ' ');

        $this->step1($client);
        $this->step2($client);
        $this->step3($client);

        fwrite(STDOUT, ' ');

        static::markTestIncomplete('Need to generate unit tests for the whole 20-steps process... One day, maybe...');
    }

    private function step1(Client $client)
    {
        $crawler = $client->request('GET', '/fr/character/generate/people');

        static::assertEquals(200, $client->getResponse()->getStatusCode(), 'Could not execute step request...');

        $form = $crawler->filter('#generator_form')->form();

        // People1: Tri-Kazel
        $form['gen-div-choice'] = 1;

        $client->submit($form);

        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate/job'));

        fwrite(STDOUT, '.');
    }

    private function step2(Client $client)
    {
        $crawler = $client->request('GET', '/fr/character/generate/job');

        static::assertEquals(200, $client->getResponse()->getStatusCode(), 'Could not execute step request...');

        $form = $crawler->filter('#generator_form')->form();

        // Job1: Artisan
        $form['job_value'] = 1;

        $client->submit($form);

        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate/birthplace'));

        fwrite(STDOUT, '.');
    }

    private function step3(Client $client)
    {
        $crawler = $client->request('GET', '/fr/character/generate/job');

        static::assertEquals(200, $client->getResponse()->getStatusCode(), 'Could not execute step request...');

        $form = $crawler->filter('#generator_form')->form();

        // Job1: Artisan
        $form['job_value'] = 1;

        $client->submit($form);

        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate/birthplace'));

        fwrite(STDOUT, '.');
    }
}

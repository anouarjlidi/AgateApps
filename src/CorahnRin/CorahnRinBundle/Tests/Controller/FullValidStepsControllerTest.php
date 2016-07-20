<?php

namespace CorahnRin\CorahnRinBundle\Tests\Controller;

use Symfony\Component\Yaml\Yaml;
use Tests\WebTestCase;

/**
 * @see CorahnRin\CorahnRinBundle\Controller\GeneratorController
 */
class FullValidStepsControllerTest extends WebTestCase
{
    /**
     * @see StepController::indexAction
     */
    public function testIndex()
    {
        $client = $this->getClient('corahnrin.esteren.dev', [], ['ROLE_MANAGER']);

        $client->request('GET', '/fr/character/generate');

        static::assertTrue($client->getResponse()
            ->isRedirect('/fr/character/generate/01_people'), 'Could not check that generator index redirects to first step');
    }

    /**
     * @see          StepController::stepAction
     * @dataProvider provideValidSteps
     *
     * @param string $stepName
     * @param string $routeUri
     * @param string $nextStep
     * @param array  $formValues
     * @param mixed  $sessionValue
     * @param array  $previousSteps
     */
    public function testAllSteps($stepName, $routeUri, $nextStep, array $formValues, $sessionValue, array $previousSteps)
    {
        if (!$formValues && !$sessionValue) {
            static::markTestIncomplete('Missing form values for step '.$stepName);
        }
        $client = $this->getClient('corahnrin.esteren.dev', [], ['ROLE_MANAGER']);

        // We need a simple session to be sure it's updated when submitting form.
        $session = $client->getContainer()->get('session');

        // Set previous steps value so we can "detach" each request to be standalone.
        $character = $session->get('character', []);
        foreach ($previousSteps as $step) {
            $character[$step['step']] = $step['session_value'];
        }
        $session->set('character', $character);
        $session->save();

        // Make the request.
        $crawler = $client->request('GET', '/fr/character/generate/'.$routeUri);

        // If it's not 200, it certainly session is invalid.
        static::assertEquals(200, $client->getResponse()->getStatusCode(), 'Could not execute step request...');

        // Prepare form values.
        $form = $crawler->filter('#generator_form')->form();

        // Sometimes, form can't be submitted properly,
        // like with "orientation" step.
        if ($formValues) {
            $form->setValues($formValues);
        }

        // Here, if the redirection is made for the next step, it means everything's valid.
        $client->submit($form);
        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate/'.$nextStep), 'Request does not redirect.');

        // We also make sure that the session has been correctly updated.
        $character = $session->get('character');
        static::assertSame($character[$stepName], $sessionValue, 'Character values are not equal to session ones...');
    }

    public static function provideValidSteps()
    {
        $file = file_get_contents(__DIR__.'/../Resources/valid_consecutive_steps.yml');

        $steps = Yaml::parse($file);

        $previous = [];

        // Force data format to fit testAllSteps' signature.
        // Also, set all previous steps to update session and not automatically follow redirects (allow steps reordering, in case of).
        foreach ($steps as $stepName => $step) {
            if (!array_key_exists('route_uri', $step)) {
                $step['route_uri'] = $stepName;
            }
            $step['step'] = $stepName;
            $data = [
                $stepName,
                $step['route_uri'],
                $step['next_step'],
                $step['form_values'] ?: [],
                $step['session_value'],
                $previous,
            ];
            $previous[] = $step;

            // Hehe, saves memory!
            yield $data;
        }
    }
}

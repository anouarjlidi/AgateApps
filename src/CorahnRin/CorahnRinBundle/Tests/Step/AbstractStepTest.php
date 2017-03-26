<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Tests\Step;

use Tests\WebTestCase;

abstract class AbstractStepTest extends WebTestCase
{
    /**
     * @return string
     */
    protected function getStepName()
    {
        return preg_replace_callback('~^CorahnRin\\\\CorahnRinBundle\\\\Tests\\\\Step\\\\Step(.+)Test$~isUu', function ($matches) {
            return preg_replace_callback('~[A-Z]~', function ($matches) {
                return '_' . strtolower($matches[0]);
            }, $matches[1]);
        }, static::class);
    }

    /**
     * @param array $sessionValues
     * @param array $formValues
     *
     * @return StepActionTestResult
     */
    protected function submitAction(array $sessionValues = [], array $formValues = [])
    {
        $client = $this->getClient('corahnrin.esteren.dev', [], ['ROLE_MANAGER']);

        // We need a simple session to be sure it's updated when submitting form.
        $session = $client->getContainer()->get('session');
        $session->set('character', $sessionValues);
        $session->save();

        // Make the request.
        $crawler = $client->request('GET', '/fr/character/generate/' . $this->getStepName());

        // If it's not 200, it certainly session is invalid.
        $statusCode = $client->getResponse()->getStatusCode();
        $errorBlock = $crawler->filter('title');
        $msg = 'Could not execute step request...';
        $msg .= $errorBlock->count() ? ("\n" . $errorBlock->text()) : (' For step "' . $this->getStepName() . '"');
        static::assertSame(200, $statusCode, $msg);

        // Prepare form values.
        $form = $crawler->filter('#generator_form')->form();

        // Sometimes, form can't be submitted properly,
        // like with "orientation" step.
        if ($formValues) {
            try {
                $form
                    ->disableValidation()
                    ->setValues($formValues)
                ;
            } catch (\Exception $e) {
                $this->fail($e->getMessage() . "\nWith values:\n" . preg_replace('~  +~', ' ', str_replace(["\r", "\n"], ' ', json_encode($formValues))));
            }
        }

        $crawler = $client->submit($form);

        // Here, if the redirection is made for the next step, it means everything's valid.
        return new StepActionTestResult($crawler, $client);
    }

}

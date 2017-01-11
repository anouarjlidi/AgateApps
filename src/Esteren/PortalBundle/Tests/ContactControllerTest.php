<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esteren\PortalBundle\Tests;

use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;
use Tests\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testValidContactForm()
    {
        parent::resetDatabase();

        $client = $this->getClient('portal.esteren.dev');

        $crawler = $client->request('GET', '/fr/contact');

        static::assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('#content .container form')->form();

        $data = [
            'name' => 'username',
            'email' => 'test@local.host',
            'subject' => 'a subject',
            'message' => 'a message for testing purpose',
        ];

        $client->submit($form, [
            'contact' => $data,
        ]);

        // Enable the profiler for the next request (it does nothing if the profiler is not available)
        $client->enableProfiler();

        static::assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $message = $client->getContainer()->get('translator')->trans('contact.message_sent');

        static::assertEquals($message, trim($crawler->filter('#flash-messages div.alert')->text()));

        /** @var MessageDataCollector $mailCollector */
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        // Check that an email was sent
        $collectedMessages = $mailCollector->getMessages();

        static::assertGreaterThanOrEqual(1, $collectedMessages);

        /** @var \Swift_Message $message */
        $message = $collectedMessages[0];

        // Asserting email data
        static::assertInstanceOf(\Swift_Message::class, $message);
        static::assertEquals($data['subject'], $message->getSubject());
        static::assertEquals($data['email'], key($message->getFrom()));
        static::assertContains($data['message'], $message->getBody());
    }

}

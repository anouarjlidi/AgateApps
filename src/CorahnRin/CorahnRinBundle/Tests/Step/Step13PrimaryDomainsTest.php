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

use Symfony\Bundle\FrameworkBundle\Client;

class Step13PrimaryDomainsTest extends AbstractStepTest
{
    /**
     * @dataProvider provideInvalidDependencies
     */
    public function testStepDependency($dependencies)
    {
        $client = parent::getClient();

        $session = $client->getContainer()->get('session');
        $session->set('character', $dependencies); // Varigal
        $session->save();

        $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate'));
    }

    public function provideInvalidDependencies()
    {
        return [
            [[]],
            [['02_job' => 1]],
            [['08_ways' => [1, 2, 3, 4, 5]]],
            [['11_advantages' => []]],
            [['02_job' => 1, '08_ways' => [1, 2, 3, 4, 5]]],
            [['11_advantages' => [], '08_ways' => [1, 2, 3, 4, 5]]],
        ];
    }

    public function testVarigalHasTwoDomainsWithScore3()
    {
        $client = $this->getStepClient(18); // Varigal id in fixtures

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertCount(15, $crawler->filter('[data-change="1"].domain-change'));
        static::assertCount(15, $crawler->filter('[data-change="2"].domain-change'));
        static::assertCount(2, $crawler->filter('[data-change="3"].domain-change'));
        static::assertCount(16, $crawler->filter('[data-change="5"].disabled'));
    }

    public function testSpyHasAllDomainsWithScore3()
    {
        $client = $this->getStepClient(9); // Spy id in fixtures

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        // 15 because domain 8 (Perception) is already set to score 5
        static::assertCount(15, $crawler->filter('[data-change="1"].domain-change'));
        static::assertCount(15, $crawler->filter('[data-change="2"].domain-change'));
        static::assertCount(15, $crawler->filter('[data-change="3"].domain-change'));
        static::assertCount(16, $crawler->filter('[data-change="5"].disabled'));
    }

    public function testSubmitNoDomain()
    {
        $client = $this->getStepClient(1); // Artisan id in fixtures

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertCount(15, $crawler->filter('[data-change="1"].domain-change'));
        static::assertCount(15, $crawler->filter('[data-change="2"].domain-change'));
        static::assertCount(2, $crawler->filter('[data-change="3"].domain-change'));
        static::assertCount(16, $crawler->filter('[data-change="5"].disabled'));

        $form = $crawler->filter('#generator_form')->form();

        $crawler = $client->submit($form);

        $flashMessagesNode = $crawler->filter('#flash-messages');

        static::assertCount(1, $flashMessagesNode);

        $flashText = $flashMessagesNode->text();

        static::assertContains('La valeur 1 doit être sélectionnée deux fois.', $flashText);
        static::assertContains('La valeur 2 doit être sélectionnée deux fois.', $flashText);
        static::assertContains('La valeur 3 doit être sélectionnée.', $flashText);
    }

    public function testSubmitInvalidDomain()
    {
        $client = $this->getStepClient(1); // Artisan id in fixtures

        $crawler = $client->request('POST', '/fr/character/generate/'.$this->getStepName(), [
            'domains' => [
                '99999999' => 1,
            ]
        ]);

        $flashMessagesNode = $crawler->filter('#flash-messages');

        static::assertCount(1, $flashMessagesNode);

        $flashText = $flashMessagesNode->text();

        static::assertContains('Les domaines envoyés sont invalides.', $flashText);
    }

    public function testWrongValueForSecondaryDomain()
    {
        $client = $this->getStepClient(1); // Artisan id in fixtures

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        $form = $crawler->filter('#generator_form')->form();

        $form->setValues([
            'domains' => [
                '3' => 3, // Close combat is not one of Artisan's secondary domains
            ],
        ]);

        $crawler = $client->submit($form);

        $flashMessagesNode = $crawler->filter('#flash-messages');

        static::assertCount(1, $flashMessagesNode);

        static::assertContains('La valeur 3 ne peut être donnée qu\'à l\'un des domaines de prédilection du métier choisi.', $flashMessagesNode->text());
    }

    public function testWrongValueForAnyDomain()
    {
        $client = $this->getStepClient(1); // Artisan id in fixtures

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        $form = $crawler->filter('#generator_form')->form();

        $form->setValues([
            'domains' => [
                '2' => 9999,
            ],
        ]);

        $crawler = $client->submit($form);

        $flashMessagesNode = $crawler->filter('#flash-messages');

        static::assertCount(1, $flashMessagesNode);

        static::assertContains('Le score d\'un domaine ne peut être que de 0, 1, 2 ou 3. Le score 5 est choisi par défaut en fonction de votre métier.', $flashMessagesNode->text());
    }

    public function testSelectScore1MoreThanTwice()
    {
        $client = $this->getStepClient(1); // Artisan id in fixtures

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        $form = $crawler->filter('#generator_form')->form();

        $form->setValues([
            'domains' => [
                '2' => 1,
                '3' => 1,
                '4' => 1,
            ],
        ]);

        $crawler = $client->submit($form);

        $flashMessagesNode = $crawler->filter('#flash-messages');

        static::assertCount(1, $flashMessagesNode);

        static::assertContains('La valeur 1 ne peut être donnée que deux fois.', $flashMessagesNode->text());
    }

    public function testSelectScore2MoreThanTwice()
    {
        $client = $this->getStepClient(1); // Artisan id in fixtures

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        $form = $crawler->filter('#generator_form')->form();

        $form->setValues([
            'domains' => [
                '2' => 2,
                '3' => 2,
                '4' => 2,
            ],
        ]);

        $crawler = $client->submit($form);

        $flashMessagesNode = $crawler->filter('#flash-messages');

        static::assertCount(1, $flashMessagesNode);

        static::assertContains('La valeur 2 ne peut être donnée que deux fois.', $flashMessagesNode->text());
    }

    /**
     * @param int   $jobId
     * @param int[] $ways
     * @param int[] $advantages
     * @param int[] $disadvantages
     *
     * @return Client
     */
    protected function getStepClient($jobId = 1, array $ways = [1, 2, 3, 4, 5], array $advantages = [], array $disadvantages = [])
    {
        $client = $this->getClient();

        $session = $client->getContainer()->get('session');
        $session->set('character', [
            '02_job' => $jobId,
            '08_ways' => $ways,
            '11_advantages' => [
                'advantages' => $advantages,
                'disadvantages' => $disadvantages,
            ],
        ]);
        $session->save();

        return $client;
    }
}

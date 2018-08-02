<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\CorahnRin\Step;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

final class StepActionTestResult
{
    private $crawler;
    private $client;

    public function __construct(Crawler $crawler, Client $client)
    {
        $this->crawler = $crawler;
        $this->client  = $client;
    }

    public function getCrawler(): Crawler
    {
        return $this->crawler;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getResponse(): Response
    {
        return $this->client->getResponse();
    }

    public function getSession(): Session
    {
        return $this->client->getContainer()->get('session');
    }
}

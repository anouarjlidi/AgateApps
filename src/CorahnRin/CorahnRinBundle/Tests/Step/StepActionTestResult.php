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
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

final class StepActionTestResult
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var Client
     */
    private $client;

    public function __construct(Crawler $crawler, Client $client)
    {
        $this->crawler = $crawler;
        $this->client  = $client;
    }

    /**
     * @return Crawler
     */
    public function getCrawler()
    {
        return $this->crawler;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return object|Response
     */
    public function getResponse()
    {
        return $this->client->getResponse();
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->client->getContainer()->get('session');
    }
}

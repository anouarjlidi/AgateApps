<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\ConnectApi;

use GuzzleHttp\Client;

abstract class AbstractApiClient implements ApiClientInterface
{
    /**
     * @var Client
     */
    protected $client;

    public function getClient(array $options = []): Client
    {
        return $this->client = new Client([
            'base_uri' => $this->getEndpoint(),
        ]);
    }
}

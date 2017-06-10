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

use GuzzleHttp\Exception\ClientException;
use Psr\Log\LoggerInterface;
use UserBundle\ConnectApi\Model\UluleUser;

final class UluleClient extends AbstractApiClient
{
    const ENDPOINT = 'https://api.ulule.com/v1/';

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getEndpoint(): string
    {
        return static::ENDPOINT;
    }

    public function basicApiTokenConnect(string $username, string $token): ?UluleUser
    {
        $client = $this->getClient();

        try {
            $response = $client->get('users/'.$username, [
                'headers' => [
                    'Authorization' => 'ApiKey '.$username.':'.$token,
                ],
            ]);
        } catch (ClientException $e) {
            if (in_array($e->getCode(), [401, 404], true)) {
                return null;
            }

            throw $e;
        }

        $data = (string) $response->getBody();

        $json = json_decode($data, true);

        if (!$json || ($json && !isset($json['id']))) {
            $this->logger->error(sprintf(
                'Ulule returned a wrong response with username %s and token %s',
                $username, $token
            ), ['profile_edit', 'ulule_connect']);

            return null;
        }

        return new UluleUser($json, $token);
    }
}

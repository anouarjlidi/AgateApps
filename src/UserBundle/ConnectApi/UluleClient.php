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

use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Cache\CacheItemPoolInterface;
use UserBundle\Model\Crowdfunding\Project;
use UserBundle\Model\Crowdfunding\UluleUser;
use UserBundle\Entity\User;

class UluleClient extends AbstractApiClient
{
    private const ENDPOINT = 'https://api.ulule.com/v1/';
    private const ULULE_PROJECTS = [
        8021,  // Esteren - Dearg
        10861, // Esteren - Voyages
        23423, // Esteren - Occultisme
        28873, // Vampire - Requiem
        30600, // Vampire - Requiem (2)
        34243, // Dragons
        51014, // 7e mer
    ];

    private $logger;
    private $cache;

    public function __construct(LoggerInterface $logger, CacheItemPoolInterface $cache)
    {
        $this->logger = $logger;
        $this->cache = $cache;
    }

    public function getEndpoint(): string
    {
        return static::ENDPOINT;
    }

    public function getClientFromUser(User $user, array $options = []): Client
    {
        if (!$user->getUluleApiToken() || !$user->getUluleUsername()) {
            throw new \InvalidArgumentException('User must have an API Token and username to get his/her projects');
        }

        $options['base_uri'] = $this->getEndpoint();

        if (!isset($options['headers'])) {
            $options['headers'] = [];
        }

        $options['headers']['Authorization'] = 'ApiKey '.$user->getUluleUsername().':'.$user->getUluleApiToken();

        return $this->client = new Client($options);
    }

    public function getUserProjects(User $user): array
    {
        $client = $this->getClientFromUser($user);

        $ululeProjects = [];

        $queryString = '?limit=50';

        do {
            $response = $client->request('GET', 'users/'.$user->getUluleId().'/projects'.$queryString.'&state=supported');

            $data = (string) $response->getBody();

            $json = json_decode($data, true);

            if (!$json || ($json && !isset($json['projects']))) {
                throw new \RuntimeException('Ulule sent a wrong response when retrieving user projects');
            }

            foreach ($json['projects'] as $project) {
                if (!in_array($project['id'], static::ULULE_PROJECTS, true)) {
                    continue;
                }
                $ululeProjects[$project['id']] = new Project($project);
            }

            $queryString = $json['meta']['next'];
        } while ($queryString);

        return $ululeProjects;
    }

    public function getUserOrders(User $user): array
    {
        $client = $this->getClientFromUser($user);

        $queryString = '?limit=50';

        $orders = [];

        do {
            $response = $client->request(
                'GET',
                'users/'.$user->getUluleId().'/orders'.$queryString.''
            );

            $data = (string)$response->getBody();

            $json = json_decode($data, true);

            if (!$json || ($json && !isset($json['orders']))) {
                throw new \RuntimeException('Ulule sent a wrong response when retrieving user projects');
            }

            foreach ($json['orders'] as $order) {
                $orders[$order['id']] = $order;
            }

            $queryString = $json['meta']['next'];
        } while ($queryString);

        return $orders;
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

        return new UluleUser($json);
    }

}

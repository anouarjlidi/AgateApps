<?php

namespace Tests;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{

    /**
     * @param string $host
     * @param array  $options
     * @param array  $tokenRoles
     *
     * @return Client
     */
    protected function getClient($host = null, array $options = array(), $tokenRoles = array())
    {
        $server = array();
        if ($host) {
            $server['HTTP_HOST'] = $host;
        }
        $client = static::createClient($options, $server);

        if ($tokenRoles) {
            static::setToken($client, 'user', $tokenRoles);
        }

        return $client;
    }

    /**
     * @param Client       $client
     * @param string       $userName
     * @param array|string $roles
     */
    protected static function setToken(Client $client, $userName = "user", $roles = array('ROLE_USER'))
    {
        $session = $client->getContainer()->get('session');

        if (is_string($roles)) {
            $roles = array($roles);
        }

        $firewall = 'main';
        $token = new UsernamePasswordToken($userName, null, $firewall, $roles);
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

}

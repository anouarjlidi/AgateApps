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
    protected function getClient($host = '', array $options = array(), $tokenRoles = array())
    {
        $server = array();
        if ($host) {
            $server['HTTP_HOST'] = $host;
        }
        $client = static::createClient($options, $server);

        if ($tokenRoles) {
            if (is_string($tokenRoles)) {
                $tokenRoles = explode(',', $tokenRoles);
            }
            $session = $client->getContainer()->get('session');
            $session->set('_security_main', serialize(new UsernamePasswordToken('Pierstoval', 'admin', 'main', $tokenRoles)));
            $session->save();
            $cookie = new Cookie($session->getName(), $session->getId());
            $client->getCookieJar()->set($cookie);
        }

        return $client;
    }

    /**
     * @param Client       $client
     * @param string       $userName
     * @param array|string $roles
     */
    protected function setToken(Client $client, $userName = "user", array $roles = array('ROLE_USER'))
    {
        $session = $client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken($userName, null, $firewall, $roles);
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

}
<?php

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class WebTestCase extends BaseWebTestCase
{

    protected static function getClient($host = '', array $options = array())
    {
        $server = array();
        if ($host) {
            $server['HTTP_HOST'] = $host;
        }
        $client = static::createClient($options, $server);

        $session = $client->getContainer()->get('session');
        $session->set('_security_main', serialize(new UsernamePasswordToken('Pierstoval', 'admin', 'main', array('ROLE_SUPER_ADMIN'))));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        return $client;
    }

}
<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/setup.html#checking-symfony-application-configuration-and-setup
// for more information
umask(0002);

$environment = (getenv('SYMFONY_ENV') !== false) ? getenv('SYMFONY_ENV') : 'dev';
$debug       = (getenv('SYMFONY_DEBUG') !== false) ? (bool) getenv('SYMFONY_DEBUG') : true;

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/../app/autoload.php';

if (false === $debug) {
    include_once __DIR__.'/../var/bootstrap.php.cache';
}

if (true === $debug) {
    Debug::enable();
} else {
    try {
        $apcLoader = new ApcClassLoader('EsterenApp', $loader);
        $apcLoader->register(true);
        $loader = $apcLoader;
    } catch (Exception $e) {
    }
}

$kernel = new AppKernel($environment, $debug);
$kernel->loadClassCache(); // To remove when SF4 comes

if (false === $debug && 'prod' === $environment) {
    $kernel = new AppCache($kernel);
    // When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
    Request::enableHttpMethodParameterOverride();
}

$request = Request::createFromGlobals();

if (getenv('HEROKU') === '1') {
//    Request::setTrustedProxies([$request->server->get('REMOTE_ADDR')], Request::HEADER_FORWARDED | Request::HEADER_X_FORWARDED_HOST);
    Request::setTrustedProxies([$request->server->get('REMOTE_ADDR')]);
    Request::setTrustedHeaderName(Request::HEADER_FORWARDED, null);
    Request::setTrustedHeaderName(Request::HEADER_CLIENT_HOST, null);
}

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

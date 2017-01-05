<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

umask(0002);

$environment = (getenv('SYMFONY_ENVIRONMENT') !== false) ? getenv('SYMFONY_ENVIRONMENT') : 'dev';
$debug       = (getenv('SYMFONY_DEBUG') !== false) ? (bool) getenv('SYMFONY_DEBUG') : true;

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/../app/autoload.php';

if (false === $debug) {
    include_once __DIR__.'/../var/bootstrap.php.cache';
}

try {
    $apcLoader = new ApcClassLoader('EsterenApp', $loader);
    $apcLoader->register(true);
    $loader = $apcLoader;
} catch (Exception $e) {}

if (true === $debug) {
    Debug::enable();
}

$kernel = new AppKernel($environment, $debug);
$kernel->loadClassCache();

if (false === $debug && 'prod' === $environment) {
    $kernel = new AppCache($kernel);
    // When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
    Request::enableHttpMethodParameterOverride();
}

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

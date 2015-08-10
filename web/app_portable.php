<?php

function setPropValue($object, $property, $value) {
    $prop = new ReflectionProperty(get_class($object), $property);
    $accessible = $prop->isPublic();
    $prop->setAccessible(true);
    $prop->setValue($object, is_callable($value) ? $value($prop->getValue($object)) : $value);
    if (!$accessible) {
        $prop->setAccessible(false);
    }
}

$pharDir = realpath(__DIR__.'/../').'/esteren.phar';
$p = new Phar($pharDir, 0, 'default.phar');
$correctPharDir = 'phar://'.$p->getAlias();

/** @var Composer\Autoload\ClassLoader $loader */
$loader = include $correctPharDir.'/app/bootstrap.php.cache';

// Fix loader issues from Phar dirs

setPropValue($loader, 'classMap', array_map(function($path) use ($pharDir, $p) {
    return str_replace($pharDir, $p->getAlias(), $path);
}, $loader->getClassMap()));

// End fixing the loader

include $correctPharDir.'/app/AppPortableCache.php';

setPropValue(new Doctrine\Common\Annotations\AnnotationRegistry, 'loaders', array());
Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(function($class) use ($loader) {
    $loader->loadClass($class);
    return class_exists($class, false);
});

$kernel = new AppPortableKernel('portable', false);

setPropValue($kernel, 'rootDir', str_replace($pharDir, $p->getAlias(), $kernel->getRootDir()));
$kernel->loadClassCache();
$kernel = new AppPortableCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
$request->enableHttpMethodParameterOverride();
$kernel->getKernel()->boot();
$container = $kernel->getKernel()->getContainer();

setPropValue($container, 'parameters', function(array $parameters) use ($pharDir, $p) {
    return array_map(function($value) use($pharDir, $p) {
        return str_replace($pharDir, $p->getAlias(), $value);
    }, $parameters);
});

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

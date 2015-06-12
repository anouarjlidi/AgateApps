<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$rootDir = realpath(__DIR__.'/../..');

$file = $rootDir.'/app/bootstrap.php.cache';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

$autoload = require_once $file;

// Remove build dir files
if (is_dir($rootDir.'/build')) {
    echo "Removing files in the build directory.\n".__DIR__."\n";
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootDir.'/build/', RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $fileinfo) {
        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
        $todo($fileinfo->getRealPath());
    }
}

AnnotationRegistry::registerLoader(function($class) use ($autoload) {
    $autoload->loadClass($class);
    return class_exists($class, false);
});

if (file_exists($rootDir.'/build/database_test.db')) {
    unlink($rootDir.'/build/database_test.db');
}

system('php '.$rootDir.'/app/console --env=test doctrine:database:create');
system('php '.$rootDir.'/app/console --env=test doctrine:schema:create');
system('php '.$rootDir.'/app/console --env=test doctrine:fixtures:load --append');

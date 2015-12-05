<?php

use Symfony\Component\Console\Input\ArgvInput;

$rootDir = realpath(__DIR__.'/../..');

$file = $rootDir.'/app/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

/** @var Composer\Autoload\ClassLoader $autoload */
$autoload = require_once $file;

$input = new ArgvInput();

if (true === $input->hasParameterOption('--no-db')) {
    return;
}

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

if (!is_dir($rootDir.'/build')) {
    mkdir($rootDir.'/build');
}

if (file_exists($rootDir.'/build/database_test.db')) {
    unlink($rootDir.'/build/database_test.db');
}

system('php '.$rootDir.'/app/console --env=test doctrine:database:create');
system('php '.$rootDir.'/app/console --env=test doctrine:schema:create');
system('php '.$rootDir.'/app/console --env=test doctrine:fixtures:load --append');

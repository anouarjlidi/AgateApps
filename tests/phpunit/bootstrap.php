<?php

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Filesystem\Filesystem;

if (!getenv('SYMFONY_ENV')) {
    putenv('SYMFONY_ENV=test');
}

$rootDir = __DIR__.'/../..';

$file = $rootDir.'/app/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

/** @var Composer\Autoload\ClassLoader $autoload */
$autoload = require_once $file;

$input = new ArgvInput();

if (getenv('TESTS_NO_DB')) {
    return;
}

$fs = new Filesystem();

// Remove build dir files
if (is_dir($rootDir.'/build')) {
    echo "Removing files in the build directory.\n".__DIR__."\n";
    $fs->remove($rootDir.'/build');
}

$fs->mkdir($rootDir.'/build');

if ($fs->exists($rootDir.'/build/database_test.db')) {
    $fs->remove($rootDir.'/build/database_test.db');
}

system('php '.$rootDir.'/bin/console cache:clear --no-warmup');
system('php '.$rootDir.'/bin/console doctrine:database:create');
system('php '.$rootDir.'/bin/console doctrine:schema:create');
system('php '.$rootDir.'/bin/console doctrine:fixtures:load --append');

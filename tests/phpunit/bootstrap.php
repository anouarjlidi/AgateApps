<?php

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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

/**
 * Execute a command.
 *
 * @param string $cmd
 */
function runCommand($cmd) {
    $process = new Process($cmd);
    $process->run(function ($type, $buffer) {
        if (Process::ERR === $type) {
            echo 'ERROR > '.$buffer;
        } else {
            echo $buffer;
        }
    });
    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }
}

runCommand('php '.$rootDir.'/bin/console cache:clear --no-warmup');

$fs = new Filesystem();

// Remove build dir files
if (!is_dir($rootDir.'/build')) {
    $fs->mkdir($rootDir.'/build');
}

if ($fs->exists($rootDir.'/build/database_test.db')) {
    $fs->remove($rootDir.'/build/database_test.db');
}

if (!getenv('TESTS_REWRITE_DB') && $fs->exists($rootDir.'/build/database_reference.db')) {
    $fs->copy($rootDir.'/build/database_reference.db', $rootDir.'/build/database_test.db');
    return;
}

runCommand('php '.$rootDir.'/bin/console doctrine:database:create');
runCommand('php '.$rootDir.'/bin/console doctrine:schema:create');
runCommand('php '.$rootDir.'/bin/console doctrine:fixtures:load --append');

$fs->copy($rootDir.'/build/database_test.db', $rootDir.'/build/database_reference.db');

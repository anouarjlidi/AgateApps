<?php

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

if (!getenv('SYMFONY_ENV')) {
    putenv('SYMFONY_ENV=test');
}

$rootDir = __DIR__.'/../..';

define('BUILD_DIR', $rootDir.'/build');

define('DATABASE_TEST_FILE', $rootDir.'/build/database_test.db');
define('DATABASE_REFERENCE_FILE', $rootDir.'/build/database_reference.db');

$file = $rootDir.'/app/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

/** @var Composer\Autoload\ClassLoader $autoload */
$autoload = require $file;

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

if (!getenv('NO_CLEAR_CACHE')) {
    runCommand('php '.$rootDir.'/bin/console cache:clear --no-warmup');
}

$fs = new Filesystem();

// Remove build dir files
if (!is_dir($rootDir.'/build')) {
    $fs->mkdir($rootDir.'/build');
}

if ($fs->exists(DATABASE_TEST_FILE)) {
    $fs->remove(DATABASE_TEST_FILE);
}

if (!getenv('TESTS_REWRITE_DB') && $fs->exists(DATABASE_REFERENCE_FILE)) {
    $fs->copy(DATABASE_REFERENCE_FILE, DATABASE_TEST_FILE);
    return;
}

runCommand('php '.$rootDir.'/bin/console doctrine:database:create');
runCommand('php '.$rootDir.'/bin/console doctrine:schema:create');
runCommand('php '.$rootDir.'/bin/console doctrine:fixtures:load --append');

$fs->copy(DATABASE_TEST_FILE, DATABASE_REFERENCE_FILE);

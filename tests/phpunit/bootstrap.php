<?php

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

define('NO_RECREATE_DB', (bool) getenv('NO_RECREATE_DB') ?: false);
define('CLEAR_CACHE', (bool) getenv('CLEAR_CACHE') ?: true);
define('RECREATE_DB', (bool) getenv('RECREATE_DB') ?: false);

if (!getenv('SYMFONY_ENV')) {
    putenv('SYMFONY_ENV=test');
}

gc_disable();
ini_set('memory_limit', -1);

$rootDir = __DIR__.'/../..';

define('BUILD_DIR', $rootDir.'/build');

define('DATABASE_TEST_FILE', $rootDir.'/build/database_test.db');
define('DATABASE_REFERENCE_FILE', $rootDir.'/build/database_reference.db');

$file = $rootDir.'/vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

/** @var Composer\Autoload\ClassLoader $autoload */
$autoload = require $file;

(new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__.'/../ci/.env');

$input = new ArgvInput();

/**
 * Execute a command.
 *
 * @param string $cmd
 */
function runCommand($cmd) {
    $process = new Process($cmd);
    $process->setTimeout(180);
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

if (!CLEAR_CACHE) {
    runCommand('php '.$rootDir.'/bin/console cache:clear --no-warmup');
    runCommand('php '.$rootDir.'/bin/console cache:warmup');
}

$fs = new Filesystem();

if (RECREATE_DB) {
    $fs->remove(DATABASE_REFERENCE_FILE);
    $fs->remove(DATABASE_TEST_FILE);
}

if ($fs->exists(DATABASE_REFERENCE_FILE)) {
    // Reset database everytime
    $fs->copy(DATABASE_REFERENCE_FILE, DATABASE_TEST_FILE, true);
    return;
}

if (NO_RECREATE_DB && file_exists($rootDir.'/build/database_reference.db')) {
    return;
}

// Remove build dir files
if (!is_dir($rootDir.'/build')) {
    $fs->mkdir($rootDir.'/build');
}

if ($fs->exists(DATABASE_TEST_FILE)) {
    $fs->remove(DATABASE_TEST_FILE);
}

runCommand('php '.$rootDir.'/bin/console doctrine:database:create');
runCommand('php '.$rootDir.'/bin/console doctrine:schema:create');
runCommand('php '.$rootDir.'/bin/console doctrine:fixtures:load --append');

$fs->copy(DATABASE_TEST_FILE, DATABASE_REFERENCE_FILE);

<?php

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Filesystem\Filesystem;

$time = microtime(true);

define('NO_RECREATE_DB', (bool) getenv('NO_RECREATE_DB') ?: false);
define('CLEAR_CACHE', (bool) getenv('CLEAR_CACHE') ?: true);
define('RECREATE_DB', (bool) getenv('RECREATE_DB') ?: false);

gc_disable();
ini_set('memory_limit', -1);
error_reporting(E_ALL);

$rootDir = __DIR__.'/..';

define('BUILD_DIR', $rootDir.'/build');

define('DATABASE_TEST_FILE', $rootDir.'/build/database_test.db');
define('DATABASE_REFERENCE_FILE', $rootDir.'/build/database_reference.db');

$file = $rootDir.'/vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

require $file;

if ($debug = ((bool) getenv('APP_DEBUG') ?: true)) {
    Debug::enable();
}

$kernel = new Kernel(getenv('APP_ENV') ?: 'test', $debug);


$runCommand = function (string $cmd) use ($kernel): void {
    $application = new Application($kernel);
    $application->setAutoExit(false);
    $code = $application->run(new StringInput($cmd));
    $kernel->shutdown();
    unset($kernel); // Triggers kernel destruct
    if ($code) {
        throw new \RuntimeException(sprintf('Command %s failed with code "%d".', $cmd, $code));
    }
};

if (CLEAR_CACHE) {
    $runCommand('cache:clear --no-warmup');
    $runCommand('cache:warmup');
}

$fs = new Filesystem();

if (RECREATE_DB) {
    $fs->remove(DATABASE_REFERENCE_FILE);
    $fs->remove(DATABASE_TEST_FILE);
}

if ($fs->exists(DATABASE_REFERENCE_FILE)) {
    // Reset database everytime
    $fs->copy(DATABASE_REFERENCE_FILE, DATABASE_TEST_FILE, true);
    goto end;
}

if (NO_RECREATE_DB && file_exists($rootDir.'/build/database_reference.db')) {
    goto end;
}

// Remove build dir files
if (!is_dir($rootDir.'/build')) {
    $fs->mkdir($rootDir.'/build');
}

if ($fs->exists(DATABASE_TEST_FILE)) {
    $fs->remove(DATABASE_TEST_FILE);
}

$runCommand('doctrine:database:create');
$runCommand('doctrine:schema:create');
$runCommand('doctrine:fixtures:load --append');

$fs->copy(DATABASE_TEST_FILE, DATABASE_REFERENCE_FILE);

$kernel->shutdown();

// Unset everything so PHPUnit can't dump these globals.
unset($rootDir, $file, $autoload, $kernel, $application, $runCommand, $fs);

end:

$seconds = (microtime(true) - $time);

echo "Bootstraped test suite in $seconds.";

#!/usr/bin/env php
<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Finder\Finder;

require __DIR__.'/../vendor/autoload.php';

(new Dotenv())->load(__DIR__.'/../.env');

$finder = new Finder();

/** @var Finder|SplFileInfo[] $files */
$files = $finder
    ->files()
    ->in(__DIR__.'/../app/config/')
    ->name('*.yml')
    ->notName('parameters.yml')
;

$envsToAdd = [];

foreach ($files as $file) {
    $filename = $file->getRealPath();
    $content = file_get_contents($filename);
    $content = preg_match_all('~%env\(([A-Z0-9_]+)\)%~', $content, $matches);

    $matchingEnvs = $matches[1] ?? [];

    foreach ($matchingEnvs as $envName) {
        $envsToAdd[$envName] = "env($envName): '".getenv($envName)."'";
    }
}

$envsToAdd['SYMFONY_ENV'] = 'env(SYMFONY_ENV): "test"';
$envsToAdd['SYMFONY_DEBUG'] = 'env(SYMFONY_DEBUG): "1"';
$envsToAdd['DATABASE_URL'] = 'env(DATABASE_URL): \'sqlite://'.dirname(__DIR__).'/build/database_test.db\'';
$envsToAdd['DATABASE_URL_LEGACY'] = 'env(DATABASE_URL_LEGACY): \'sqlite://'.dirname(__DIR__).'/build/database_test_legacy.db\'';

$envsToAdd = '    '.implode("\n    ", $envsToAdd);

$paramsFile = __DIR__.'/../app/config/parameters.yml';

$params = file_get_contents($paramsFile);

$params = preg_replace("~parameters:\n~i", "parameters:\n$envsToAdd\n", $params);

file_put_contents($paramsFile, $params);

<?php

require __DIR__.'/../app/bootstrap.php.cache';

$params = Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__.'/../app/config/parameters.yml'));
$params = $params['parameters'];

$config = new Doctrine\DBAL\Configuration();
$dbParams = array(
    'driver' => $params['database_driver'],
    'host' => $params['database_host'],
    'port' => $params['database_port'],
    'dbname' => $params['database_name'],
    'user' => $params['database_user'],
    'password' => $params['database_password'],
    'charset' => 'UTF8',
    'path' => $params['database_path'],
    'driverOptions' => array(),
);

if ($dbParams['path']) {
    $dbParams['path'] = str_replace('%kernel.root_dir%', __DIR__.'/../app', $dbParams['path']);
    $dbParams['path'] = realpath($dbParams['path']);
}

$dbal = Doctrine\DBAL\DriverManager::getConnection($dbParams, $config);
$dbal->connect();

$isSqlite = $dbal->getDatabasePlatform() instanceof Doctrine\DBAL\Platforms\SqlitePlatform;

$fixtures = require 'fixtures.php';

foreach ($fixtures as $table => $lines) {
    if (!count($lines)) { continue; }

    try {
        $dbal->query('delete from '.$table)->execute();
    } catch (Doctrine\DBAL\DBALException $e) {
        if (strpos($e->getMessage(), 'no such table')) {
            echo 'No table '.$table.PHP_EOL;
        }
    }

    $sqls = array();

    foreach ($lines as $line) {
        $dbal->insert($table, $line);
        echo "Inserted into $table values with id {$line['id']}.\n";
    }
}

$dbal->close();

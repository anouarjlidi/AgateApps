<?php

define('DS', DIRECTORY_SEPARATOR);

$loader = include __DIR__.DS.'app'.DS.'bootstrap.php.cache';

$fs = new Symfony\Component\Filesystem\Filesystem();

$remove = array(
    '_dev_files',
    'app/config/_app_web.yml',
    'app/config/config_prod.yml',
    'app/config/config_dev.yml',
    'app/config/config_test.yml',
    'app/config/routing_dev.yml',
    'app/config/routing__corahnrin.yml',
    'app/config/routing__fos.yml',
    'app/config/routing__orbitale.yml',
    'app/config/routing__portal.yml',
    'app/cache/dev',
    'app/cache/prod',
    'app/cache/portable',
    'app/check.php',
    'app/SymfonyRequirements.php',
    'app/phpunit.xml.dist',
    'node_modules',
    'web/app.php',
    'web/app_dev.php',
    'web/config.php',
    'web/robots.txt',
    'web/uploads/maps',
    'web/components/bootstrap',
    'web/components/jquery/src',
    'web/components/jquery/bower.json',
    'web/components/jquery/.bower.json',
    'web/components/jquery/MIT-LICENSE.txt',
    'web/components/jquery.colorpicker',
    'web/components/jquery-ui',
    'web/components/leaflet',
    'web/components/leaflet-draw',
    'web/components/leaflet-sidebar',
    'src/AdminBundle',
    'src/Tests',
    'src/CorahnRin/Classes',
    'src/CorahnRin/DataFixtures',
    'src/CorahnRin/Form',
    'src/CorahnRin/PDF',
    'src/CorahnRin/Steps',
    'src/CorahnRin/SheetsManagers/files',
    'src/CorahnRin/Resources/public',
    'src/CorahnRin/Resources/views',
    'src/UserBundle/DataFixtures',
    'src/EsterenMaps/MapsBundle/DataFixtures',
    'vendor/javiereguiluz/easyadmin-bundle',
    'vendor/orbitale/cms-bundle',
    'vendor/nelmio/cors-bundle',
    '.bowerrc',
    '.gitattributes',
    '.gitignore',
    '.travis.yml',
    'bower.json',
    'composer.json',
    'composer.lock',
    'cc.cmd',
    'cs',
    'cs.bat',
    'init_acl.sh',
    'package.json',
    'reset.bash',
    'README.md',
);

foreach ($remove as $path) {
    $path = str_replace('/', DS, $path);
    $fs->remove(__DIR__.DS.$path);
}



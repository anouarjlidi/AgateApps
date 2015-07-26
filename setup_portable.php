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
    'web/bundles/corahnrin',
    'web/bundles/easyadmin',
    'web/bundles/framework',
    'web/bundles/orbitaletranslation',
    'web/bundles/sensiodistribution',
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

// Delete with wildcards
$remove = array(
    'src/*/*Bundle/Resources/public',
    'vendor/*/*/*.dist',
    'vendor/*/*/*.json',
    'vendor/*/*/*.md',
    'vendor/*/*/LICENSE',
    'vendor/*/*/.git*',
    'vendor/*/*/.travis*',
    'vendor/*/*/.coveralls*',
    'vendor/*/*/Tests',
    'vendor/*/*/src/*/*/*.dist',
    'vendor/*/*/src/*/*/*.json',
    'vendor/*/*/src/*/*/*.md',
    'vendor/*/*/src/*/*/LICENSE',
    'vendor/*/*/src/*/*/.git*',
    'vendor/*/*/src/*/*/.travis*',
    'vendor/*/*/src/*/*/.coveralls*',
    'vendor/*/*/src/*/*/Tests',
    'vendor/symfony/symfony/src/Symfony/*/*/*.dist',
    'vendor/symfony/symfony/src/Symfony/*/*/*.md',
    'vendor/symfony/symfony/src/Symfony/*/*/*.json',
    'vendor/symfony/symfony/src/Symfony/*/*/LICENSE',
    'vendor/symfony/symfony/src/Symfony/*/*/.git*',
    'vendor/symfony/symfony/src/Symfony/*/*/.travis*',
    'vendor/symfony/symfony/src/Symfony/*/*/.coveralls*',
    'vendor/symfony/symfony/src/Symfony/*/*/Tests',
);
foreach ($remove as $path) {
    exec('rm -rf '.__DIR__.'/'.$path);
}

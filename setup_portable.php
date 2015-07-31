<?php

$bytesDeleted = 0;
$filesDeleted = 0;

$dryRun = !in_array('-f', $argv);

system('rm -rf app/cache/*');
system('rm -rf app/log/*');

if (!$dryRun) {
    system('npm install');
    system('rm -rf vendor');
    system('composer install --no-scripts --no-dev');

    // First, create all the assets
    system('rm -rf '.__DIR__.'/js/*');
    system('rm -rf '.__DIR__.'/css/*');
    system('php app/console_portable assets:install');
    system('php app/console_portable assetic:dump --no-debug');
}

$loader = include __DIR__.'/app/bootstrap.php.cache';

$fs = new Symfony\Component\Filesystem\Filesystem();

function getFinder() {
    $finder = new Symfony\Component\Finder\Finder();
    $finder->ignoreDotFiles(false);
    $finder->ignoreUnreadableDirs(false);
    $finder->ignoreVCS(false);
    return $finder;
}

// Delete unused app files
$remove = array(
    '_dev_files',
    'build',
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
    'app/AppKernel.php',
    'app/SymfonyRequirements.php',
    'app/phpunit.xml.dist',
    'app/console',
    'app/logs/prod.log',
    'app/logs/test.log',
    'app/logs/dev.log',
    'app/logs/apache_access.log',
    'app/logs/apache_error.log',
    'node_modules',
    'web/app.php',
    'web/app_dev.php',
    'web/config.php',
    'web/robots.txt',
    'web/uploads/maps',
    'web/uploads/media',
    'web/bundles/corahnrin',
    'web/bundles/easyadmin',
    'web/bundles/esterenmaps',
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
    'vendor/twig/twig/doc',
    'vendor/stof/doctrine-extensions-bundle/Stof/DoctrineExtensionsBundle/Resources/doc',
    'vendor/swiftmailer/swiftmailer/doc',
    'vendor/twig/extensions/doc',
    'vendor/sensio/generator-bundle/Sensio/Bundle/GeneratorBundle/Resources/doc',
    'vendor/sensio/framework-extra-bundle/Resources/doc',
    'vendor/phpcollection/phpcollection/doc',
    'vendor/knplabs/knp-menu/doc',
    'vendor/jms/serializer/doc',
    'vendor/jms/parser-lib/doc',
    'vendor/sensio/framework-extra-bundle/Resources/doc',
    'vendor/gedmo/doctrine-extensions/doc',
    'vendor/friendsofsymfony/user-bundle/FOS/UserBundle/Resources/doc',
    'vendor/doctrine/orm/docs',
    'vendor/doctrine/doctrine-fixtures-bundle/Doctrine/Bundle/FixturesBundle/Resources/doc',
    'vendor/doctrine/doctrine-bundle/Resources/doc',
    'vendor/friendsofsymfony/rest-bundle/FOS/RestBundle/Resources/doc',
    'vendor/sensio/distribution-bundle/Sensio/Bundle/DistributionBundle/Resources/skeleton',
    'vendor/sensio/generator-bundle/Sensio/Bundle/GeneratorBundle/Resources/skeleton',
    'vendor/gedmo/doctrine-extensions/example',
    'vendor/jdorn/sql-formatter/examples',
    'vendor/symfony/symfony/src/Symfony/Component/Debug/Resources/ext',
    'vendor/symfony/symfony/src/Symfony/Component/Intl/Resources/bin',
    'vendor/symfony/symfony/src/Symfony/Component/Intl/Resources/data/svn-info.txt',
    'vendor/twig/twig/ext',
    'vendor/psr/log/Psr/Log/Test',
    'vendor/symfony/symfony/src/Symfony/Bridge/Doctrine/Test',
    'vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Test',
    'vendor/symfony/symfony/src/Symfony/Component/Form/Test',
    'vendor/symfony/symfony/src/Symfony/Component/VarDumper/Test',
    'vendor/twig/extensions/test',
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
    $path = __DIR__.'/'.$path;
    if (!file_exists($path)) {
        continue;
    }
    if (is_dir($path)) {
        foreach (getFinder()->files()->in($path) as $file) {
            /** @var Symfony\Component\Finder\SplFileInfo $file */
            echo "[file-] {$file->getRealPath()}\n";
            $filesDeleted ++;
            $bytesDeleted += $file->getSize();
        }
    } else {
        echo "[file-] $path\n";
        $filesDeleted ++;
        $bytesDeleted += filesize($path);
    }
    if (!$dryRun) {
        $fs->remove($path);
    }
}
unset($path);

// Delete with wildcards, mostly for vendors
$remove = array(
    'LICENSE',
    'composer.lock',
    'composer.json',
    '*.md',
    '*.markdown',
    '*.mdown',
    '*.rst',
    '*.dist',
    '*.sh',
    '*.php_cs',
    'README',
    'UPGRADE*.md',
    'UPGRADE',
    'UPGRADE_TO*',
    'CHANGELOG',
    'CHANGES',
    'VERSION',
    'CONTRIBUT*',
    '.gitignore',
    '.gitattributes',
    '.gitconfig',
    '.gitmodules',
    '.gitkeep',
    '.editorconfig',
    '.travis*',
    '.coveralls*',
    'phpunit.xml*',
    'build.xml*',
    'build.properties*',
    'Tests',
    'Test',
    'public',
);

$findCommand = 'find '.__DIR__.' ';

$remove = array_map(function ($e) {
    return ' -iname "'.$e.'" ';
}, $remove);

$findCommand .= implode(' -o ', $remove);

exec($findCommand, $r, $c);

$str = '';

foreach ($r as $path) {
    if (!file_exists($path)) {
        continue;
    }
    if (is_dir($path)) {
        foreach (getFinder()->files()->in($path) as $file) {
            /** @var Symfony\Component\Finder\SplFileInfo $file */
            echo "[file-] {$file->getRealPath()}\n";
            $filesDeleted ++;
            $bytesDeleted += $file->getSize();
        }
    } else {
        echo "[file-] $path\n";
        $filesDeleted ++;
        $bytesDeleted += filesize($path);
    }
    if (!$dryRun) {
        $fs->remove($path);
    }
}
unset($path);

echo "Deleted $filesDeleted files\n";

$bytes = $bytesDeleted;

$units = array('B', 'KB', 'MB', 'GB', 'TB');
$pow   = min(floor(($bytes ? log($bytes) : 0) / log(1024)), count($units) - 1);
$bytes /= (1 << (10 * $pow));

echo "Saved $bytesDeleted bytes ( ".round($bytes, 2).' '.$units[$pow]." )\n";

$boxFile = __DIR__.'/box.json';

if (file_exists($boxFile)) {
    $boxJson = json_decode(file_get_contents($boxFile), true);
} else {
    $boxJson = array();
}

$boxJson = array_merge(array(
    'files'  => array(),
    'main'   => 'app/console',
    'output' => 'app.phar',
    'stub'   => true,
), $boxJson);

$filesToAdd = array();

//$dirsToAdd = array(
//    'app',
//    'bin',
//    'src',
//    'vendor',
//);
//foreach ($dirsToAdd as $dir) {
//    foreach (getFinder()->files()->in(__DIR__.'/'.$dir) as $file) {
//        /** @var Symfony\Component\Finder\SplFileInfo $file */
//        $boxJson['files'][] = $dir.'/'.$file->getRelativePathName();
//    }
//}
//
//$json = json_encode($boxJson, 480);
//
//if (!$dryRun) {
//    echo "Update box.json file\n";
//    file_put_contents($boxFile, $json);
//}
//
//if ($dryRun) {
//    echo "Finished dry run\n";
//}
//
//echo "Done!\n";

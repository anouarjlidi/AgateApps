<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function getCacheDir(): string
    {
        return dirname(__DIR__).'/var/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return dirname(__DIR__).'/var/log';
    }

    public function registerBundles()
    {
        $contents = require dirname(__DIR__).'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $confDir = dirname(__DIR__).'/config';

        // Load packages files.
        $loader->load($confDir.'/packages/*'.self::CONFIG_EXTS, 'glob');

        // Load packages environment-specific files.
        if (is_dir($confDir.'/packages/'.$this->environment)) {
            $loader->load($confDir.'/packages/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        }

        $loader->load($confDir.'/app'.self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = dirname(__DIR__).'/config';

        // Load environment-specific routes that match "_{env}.{ext}"
        // The advantage is that we can easily define routes in the order we want.
        // And we want order...
        if (file_exists($confDir.'/routes/_'.$this->environment.'.yaml')) {
            $routes->import($confDir.'/routes/_'.$this->environment.'.yaml', null, 'yaml');
        } else {
            throw new \RuntimeException(sprintf('Route file for environment %s does not exist.', $this->environment));
        }
    }
}

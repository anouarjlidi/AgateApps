<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function getCacheDir()
    {
        return $this->getProjectDir().'/var/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return $this->getProjectDir().'/var/log';
    }

    public function registerBundles()
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);

        $confDir = $this->getProjectDir().'/config';

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
        $routesDir = $this->getProjectDir().'/config/routes';

        $env = $this->environment;

        $routeFile = "$routesDir/_$env.yaml";

        // Load environment-specific routes that match "_{env}.{ext}"
        // The advantage is that we can easily define routes in the order we want.
        // And we want order...
        if (file_exists($routeFile)) {
            $routes->import($routeFile, null, 'yaml');
        } else {
            throw new \RuntimeException(sprintf('Route file for environment %s does not exist.', $env));
        }
    }
}

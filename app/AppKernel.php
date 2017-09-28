<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Nelmio\CorsBundle\NelmioCorsBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            // Application global
            new UserBundle\UserBundle(),
            new AdminBundle\AdminBundle(),
            new AgateBundle\AgateBundle(),

            // Corahn-Rin
            new Pierstoval\Bundle\CharacterManagerBundle\PierstovalCharacterManagerBundle(),
            new CorahnRin\CorahnRinBundle\CorahnRinBundle(),

            // Esteren
            new Esteren\PortalBundle\EsterenPortalBundle(),

            // Esteren Maps
            new EsterenMaps\MapsBundle\EsterenMapsBundle(),

            // Pierstoval's tools
            new Orbitale\Bundle\CmsBundle\OrbitaleCmsBundle(),
            new Pierstoval\Bundle\ToolsBundle\PierstovalToolsBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test', 'heroku'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}

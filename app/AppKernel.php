<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {

        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),

            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            new JMS\SerializerBundle\JMSSerializerBundle($this),

            new FOS\UserBundle\FOSUserBundle(),
            new FOS\RestBundle\FOSRestBundle(),

            new CorahnRin\CharactersBundle\CorahnRinCharactersBundle(),
            new CorahnRin\UsersBundle\CorahnRinUsersBundle(),
            new CorahnRin\ToolsBundle\CorahnRinToolsBundle(),
            new CorahnRin\GeneratorBundle\CorahnRinGeneratorBundle(),

            new EsterenMaps\MapsBundle\EsterenMapsBundle(),

            new Esteren\PagesBundle\EsterenPagesBundle(),

            new Pierstoval\Bundle\ApiBundle\PierstovalApiBundle(),
            new Pierstoval\Bundle\TranslationBundle\PierstovalTranslationBundle(),
            new Pierstoval\Bundle\ToolsBundle\PierstovalToolsBundle(),
            new Pierstoval\Bundle\AdminBundle\PierstovalAdminBundle(),
            new CorahnRin\AdminBundle\CorahnRinAdminBundle(),
            new CorahnRin\ModelsBundle\CorahnRinModelsBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test','dev_fast'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}

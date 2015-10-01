<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppPortableKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new FOS\UserBundle\FOSUserBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            // Application global
            new UserBundle\UserBundle(),

            // Corahn-Rin
            new CorahnRin\CorahnRinBundle\CorahnRinBundle(),

            // Esteren
            new Esteren\PortalBundle\EsterenPortalBundle(),

            // Esteren Maps
            new EsterenMaps\MapsBundle\EsterenMapsBundle(),
            new EsterenMaps\ApiBundle\EsterenMapsApiBundle(),

            // Pierstoval's tools
            new Pierstoval\Bundle\ApiBundle\PierstovalApiBundle(),
            new Pierstoval\Bundle\ToolsBundle\PierstovalToolsBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    /**
     * This trick allows using an external directory when compiled as a phar
     *
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return str_replace(array('phar://', 'esteren.phar/'), '', __DIR__).'/cache/'.$this->environment;
    }

    /**
     * This trick allows using an external directory when compiled as a phar
     *
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return str_replace(array('phar://', 'esteren.phar/'), '', __DIR__).'/logs/'.$this->environment;
    }
}

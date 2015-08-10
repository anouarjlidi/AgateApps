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
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new FOS\UserBundle\FOSUserBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new Nelmio\CorsBundle\NelmioCorsBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle(),
            new Lexik\Bundle\TranslationBundle\LexikTranslationBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            // Application global
            new UserBundle\UserBundle(),
            new AdminBundle\AdminBundle(),

            // Corahn-Rin
            new CorahnRin\CorahnRinBundle\CorahnRinBundle(),

            // Esteren
            new Esteren\PortalBundle\EsterenPortalBundle(),

            // Esteren Maps
            new EsterenMaps\MapsBundle\EsterenMapsBundle(),
            new EsterenMaps\ApiBundle\EsterenMapsApiBundle(),

            // Pierstoval's tools
            new Orbitale\Bundle\CmsBundle\OrbitaleCmsBundle(),
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
}

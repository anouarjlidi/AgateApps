<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(

            // Symfony
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle(),

            // Sonata et dépendances
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\NotificationBundle\SonataNotificationBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),

            // Application global
            new Application\AdminBundle\ApplicationAdminBundle(),
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),

            // Corahn-Rin
            new CorahnRin\CorahnRinBundle\CorahnRinBundle(),

            // Esteren général
            new Esteren\PortalBundle\EsterenPortalBundle(),
            new Esteren\PagesBundle\EsterenPagesBundle(),
            new Esteren\UserBundle\EsterenUserBundle(),

            // Esteren Maps
            new EsterenMaps\MapsBundle\EsterenMapsBundle(),
            new EsterenMaps\ApiBundle\EsterenMapsApiBundle(),
            new EsterenMaps\AdminBundle\EsterenMapsAdminBundle(),

            // Pierstoval's tools
            new Pierstoval\Bundle\ApiBundle\PierstovalApiBundle(),
            new Pierstoval\Bundle\CorsBundle\PierstovalCorsBundle(),
            new Pierstoval\Bundle\ToolsBundle\PierstovalToolsBundle(),
            new Orbitale\Bundle\CmsBundle\OrbitaleCmsBundle(),
            new Orbitale\Bundle\TranslationBundle\OrbitaleTranslationBundle(),
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

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
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            // Doctrine
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            // JMS
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            // FOS
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            // Sonata et dépendances
            new Sonata\SeoBundle\SonataSeoBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\PageBundle\SonataPageBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\CacheBundle\SonataCacheBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            new Sonata\NotificationBundle\SonataNotificationBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            // Local Sonata generated bundles
            new Application\Sonata\PageBundle\ApplicationSonataPageBundle(),
            new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
            new Application\Sonata\AdminBundle\ApplicationSonataAdminBundle(),
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
            // Corahn-Rin
            new CorahnRin\AdminBundle\CorahnRinAdminBundle(),
            new CorahnRin\CharactersBundle\CorahnRinCharactersBundle(),
            new CorahnRin\UsersBundle\CorahnRinUsersBundle(),
            new CorahnRin\ModelsBundle\CorahnRinModelsBundle(),
            new CorahnRin\ToolsBundle\CorahnRinToolsBundle(),
            new CorahnRin\GeneratorBundle\CorahnRinGeneratorBundle(),
            // Esteren général
            new Esteren\PagesBundle\EsterenPagesBundle(),
            // Esteren Maps
            new EsterenMaps\MapsBundle\EsterenMapsBundle(),
            // Pierstoval's tools
            new Pierstoval\Bundle\ApiBundle\PierstovalApiBundle(),
            new Pierstoval\Bundle\ToolsBundle\PierstovalToolsBundle(),
            new Pierstoval\Bundle\AdminBundle\PierstovalAdminBundle(),
            new Pierstoval\Bundle\TranslationBundle\PierstovalTranslationBundle(),

        );

        if (in_array($this->getEnvironment(), array('dev', 'test', 'dev_fast'))) {
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

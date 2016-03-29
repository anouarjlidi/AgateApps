<?php

namespace CorahnRin\CorahnRinBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CorahnRinExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        foreach ($config as $name => $value) {
            preg_match_all('#%([^%]+)%#isUu', $value, $matches, PREG_PATTERN_ORDER);
            foreach ($matches[0] as $k => $match) {
                $value = str_replace($match, $container->getParameter($matches[1][$k]), $value);
            }
            $config[$name] = $value;
        }

        if (isset($config['sheets_folder']) && !is_dir($config['sheets_folder'])) {
            throw new \Exception('Le dossier des feuilles de personnage doit être un dossier valide.');
        }

        if (isset($config['sheets_output']) && !is_dir($config['sheets_output']) && is_writable($config['sheets_output'])) {
            mkdir($config['sheets_output'], 0775, true);
        }

        foreach ($config as $name => $value) {
            $container->setParameter('corahn_rin_generator.'.$name, $value);
        }
    }
}

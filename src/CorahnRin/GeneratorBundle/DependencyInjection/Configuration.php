<?php

namespace CorahnRin\GeneratorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('corahn_rin_generator');

        $rootNode
            ->children()
                ->scalarNode('sheets_folder')
                    ->defaultValue(__DIR__.'/../Sheets/files')
                    ->info('Defines the folder where all character sheets are stored, in order to use them with the character sheet manager.')
                    ->example('%kernel.root_dir%/../src/CorahnRin/GeneratorsBundle/Sheets/files/')
                ->end()
                ->scalarNode('sheets_output')
                    ->defaultValue('%kernel.root_dir%/cache/character_sheets/')
                    ->info('Defines the folder where the sheets will be saved for "caching".')
                    ->example('%kernel.root_dir%/cache/character_sheets/')
                ->end()
            ->end()
        ;

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}

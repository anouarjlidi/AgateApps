<?php

namespace EsterenMaps\MapsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('esterenmaps');

        $rootNode
            ->children()
                ->scalarNode('tile_size')
                    ->defaultValue(168)
                    ->info('La largeur et la hauteur des tuiles générées par l\'application Maps')
                    ->example('168')
                    ->validate()
                    ->always()
                        ->then(function($value) {
                            if (!is_numeric($value)) {
                                throw new InvalidConfigurationException('Tile size must be a valid integer.');
                            }
                            return (int) $value;
                        })
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

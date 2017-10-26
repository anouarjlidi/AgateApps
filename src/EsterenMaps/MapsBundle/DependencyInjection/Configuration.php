<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

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
                        ->then(function ($value) {
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

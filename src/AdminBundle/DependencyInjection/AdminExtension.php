<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\DependencyInjection;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class AdminExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        /** @var SplFileInfo[] $files */
        $files = Finder::create()
            ->files()
            ->name('*.yml')
            ->in($container->getParameter('kernel.root_dir').'/config/admin/')
        ;

        // This allows recompiling the container when we update a config file
        foreach ($files as $file) {
            $container->addResource(new FileResource($file->getRealPath()));
        }
    }
}

<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esteren\PortalBundle\DataFixtures\ORM;

use Esteren\PortalBundle\Entity\Page;
use Orbitale\Component\DoctrineTools\AbstractFixture;
use Pierstoval\Bundle\ToolsBundle\Doctrine\FixtureMetadataIdGeneratorTrait;

class PageFixtures extends AbstractFixture
{
    use FixtureMetadataIdGeneratorTrait;

    /**
     * {@inheritdoc}
     */
    public function getOrder(): int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass(): string
    {
        return Page::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferencePrefix(): ?string
    {
        return 'esteren-portal-page-';
    }

    /**
     * {@inheritdoc}
     */
    public function getObjects()
    {
        return [
            [
                'title'    => 'Homepage',
                'slug'     => 'homepage',
                'content'  => 'This this a default home page.',
                'host'     => null,
                'enabled'  => true,
                'homepage' => true,
            ],
            [
                'title'    => 'Static page',
                'slug'     => 'static-page',
                'content'  => 'This this a default static page.',
                'host'     => null,
                'enabled'  => true,
                'homepage' => false,
            ],
        ];
    }
}

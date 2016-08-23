<?php

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
    public function getOrder()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Page::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferencePrefix()
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
                'id'        => 1,
                'title'     => 'Homepage',
                'slug'      => 'homepage',
                'content'   => 'This this a default home page.',
                'enabled'   => true,
                'homepage'  => true,
            ],
        ];
    }
}

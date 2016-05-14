<?php

namespace Esteren\PortalBundle\DataFixtures\ORM;

use Orbitale\Bundle\CmsBundle\Entity\Page;
use Orbitale\Component\DoctrineTools\AbstractFixture;

class PageFixtures extends AbstractFixture
{

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
                'title'     => 'Homepage',
                'slug'      => 'homepage',
                'content'   => 'This this a default home page.',
                'enabled'   => true,
                'homepage'  => true,
                'createdAt' => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-05-14 15:26:55'),
                'updatedAt' => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-05-14 15:26:55'),
                'deletedAt' => null,
            ],
        ];
    }
}

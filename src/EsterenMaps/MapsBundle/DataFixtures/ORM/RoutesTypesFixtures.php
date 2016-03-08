<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Orbitale\Component\DoctrineTools\AbstractFixture;

class RoutesTypesFixtures extends AbstractFixture
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
        return 'EsterenMaps\MapsBundle\Entity\RoutesTypes';
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        return [
            [
                'id'          => 1,
                'name'        => 'Chemin',
                'description' => '',
                'color'       => 'rgba(165,110,52,1)',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 2,
                'name'        => 'Route',
                'description' => '',
                'color'       => 'rgba(199,191,183,1)',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 3,
                'name'        => 'Sentier de loup',
                'description' => '',
                'color'       => 'rgba(194,176,76,1)',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 4,
                'name'        => 'Liaison maritime',
                'description' => '',
                'color'       => 'rgba(64,148,220,0.4)',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-24 10:52:59'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 5,
                'name'        => 'Voie fluviale',
                'description' => '',
                'color'       => 'rgba(64,220,191,0.4)',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-24 10:52:41'),
                'deletedAt'   => null,
            ],
        ];
    }
}

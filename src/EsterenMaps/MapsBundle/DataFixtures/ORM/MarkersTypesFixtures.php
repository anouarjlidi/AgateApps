<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Orbitale\Component\DoctrineTools\AbstractFixture;
use Pierstoval\Bundle\ToolsBundle\Doctrine\FixtureMetadataIdGeneratorTrait;

class MarkersTypesFixtures extends AbstractFixture
{
    use FixtureMetadataIdGeneratorTrait;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return 'EsterenMaps\MapsBundle\Entity\MarkersTypes';
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferencePrefix()
    {
        return 'esterenmaps-markerstypes-';
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        return [

            [
                'id'          => 1,
                'name'        => 'Cité',
                'description' => '',
                'icon'        => 'pastille-beige.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 2,
                'name'        => 'Port (village côtier, ...)',
                'description' => '',
                'icon'        => 'pastille-blue.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 3,
                'name'        => 'Passage',
                'description' => '',
                'icon'        => 'pastille-green.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:22'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 4,
                'name'        => 'Sanctuaire',
                'description' => '',
                'icon'        => 'pastille-green-dark.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 5,
                'name'        => 'Site d\'intérêt',
                'description' => '',
                'icon'        => 'pastille-red-dark.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 6,
                'name'        => 'Fortifications (châteaux, angardes, rosace)',
                'description' => '',
                'icon'        => 'pastille-gray.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 7,
                'name'        => 'Souterrain (mine, cité troglodyte, réseau de cavernes)',
                'description' => '',
                'icon'        => 'pastille-red-darker.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 8,
                'name'        => 'Établissement',
                'description' => '',
                'icon'        => 'pastille-gray-light.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 9,
                'name'        => 'Lieu hanté ou maudit',
                'description' => '',
                'icon'        => 'pastille-blue-dark.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 10,
                'name'        => 'Marqueur invisible',
                'description' => '',
                'icon'        => 'invisible.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 11,
                'name'        => 'Village',
                'description' => '',
                'icon'        => 'pastille-beige-light.png',
                'iconWidth'   => 16,
                'iconHeight'  => 16,
                'iconCenterX' => null,
                'iconCenterY' => null,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
        ];
    }
}

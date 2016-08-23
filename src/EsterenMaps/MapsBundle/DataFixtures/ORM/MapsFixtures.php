<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use EsterenMaps\MapsBundle\Entity\Maps;
use Orbitale\Component\DoctrineTools\AbstractFixture;
use Pierstoval\Bundle\ToolsBundle\Doctrine\FixtureMetadataIdGeneratorTrait;

class MapsFixtures extends AbstractFixture
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
        return Maps::class;
    }

    protected function getReferencePrefix()
    {
        return 'esterenmaps-maps-';
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        return [
            [
                'id'               => 1,
                'name'             => 'Tri-Kazel',
                'nameSlug'         => 'tri-kazel',
                'image'            => 'uploads/maps/esteren_map.jpg',
                'description'      => 'Carte de Tri-Kazel officielle, réalisée par Chris.',
                'maxZoom'          => 5,
                'startZoom'        => 2,
                'startX'           => 65,
                'startY'           => 85,
                'coordinatesRatio' => 5,
                'bounds'           => '[[134,-1],[-1,169]]',
                'createdAt'        => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'        => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-23 14:46:09'),
                'deletedAt'        => null,
            ],
        ];
    }
}

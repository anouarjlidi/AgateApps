<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Orbitale\Component\DoctrineTools\AbstractFixture;

class MapsFixtures extends AbstractFixture
{

    /**
     * {@inheritdoc}
     */
    function getOrder()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return 'EsterenMaps\MapsBundle\Entity\Maps';
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
        return array(
            array(
                'id' => 1,
                'name' => 'Tri-Kazel',
                'nameSlug' => 'tri-kazel',
                'image' => 'uploads/maps/esteren_map.jpg',
                'description' => 'Carte de Tri-Kazel officielle, réalisée par Chris',
                'maxZoom' => 5,
                'startZoom' => 2,
                'startX' => 50,
                'startY' => 0,
                'bounds' => '[[85.3,-183.7],[-12.8,64.3]]'
            ),
        );
    }
}

<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Orbitale\Component\DoctrineTools\AbstractFixture;

class MarkersTypesFixtures extends AbstractFixture
{
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
     * Returns a list of objects to
     *
     * @return ArrayCollection|object[]
     */
    protected function getObjects()
    {
        return array(
            array('id' => 1,  'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-beige.png',  'name' => 'Cité',                        'description' => ''),
            array('id' => 2,  'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-blue.png',  'name' => 'Port (village côtier, ...)',  'description' => ''),
            array('id' => 3,  'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-green.png', 'name' => 'Carrefour',                   'description' => ''),
            array('id' => 4,  'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-green-dark.png', 'name' => 'Sanctuaire',                  'description' => ''),
            array('id' => 5,  'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-red-dark.png',  'name' => 'Site d\'intérêt',             'description' => ''),
            array('id' => 6,  'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-gray.png',  'name' => 'Fortifications (châteaux, angardes, rosace)', 'description' => ''),
            array('id' => 7,  'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-red-darker.png', 'name' => 'Souterrain (mine, cité troglodyte, réseau de cavernes)', 'description' => ''),
            array('id' => 8,  'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-gray-light.png', 'name' => 'Établissement',               'description' => ''),
            array('id' => 9,  'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-blue-dark.png', 'name' => 'Lieu hanté ou maudit',        'description' => ''),
            array('id' => 10, 'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'invisible.png',       'name' => 'Marqueur invisible',          'description' => ''),
            array('id' => 11, 'iconWidth' => 16, 'iconHeight' => 16, 'icon' => 'pastille-beige-light.png', 'name' => 'Village',                     'description' => ''),
        );
    }
}
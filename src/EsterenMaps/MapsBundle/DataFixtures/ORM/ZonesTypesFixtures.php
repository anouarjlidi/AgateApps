<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Orbitale\Component\DoctrineTools\AbstractFixture;

class ZonesTypesFixtures extends AbstractFixture
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
        return 'EsterenMaps\MapsBundle\Entity\ZonesTypes';
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferencePrefix()
    {
        return 'esterenmaps-zonestypes-';
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        return [
            [
                'id'          => 1,
                'parent_id'   => null,
                'name'        => 'Politique',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 2,
                'parent'      => $this->getReference('esterenmaps-zonestypes-1'),
                'name'        => 'Royaume',
                'description' => '',
                'color'       => '#E05151',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 3,
                'parent'      => $this->getReference('esterenmaps-zonestypes-1'),
                'name'        => 'Territoire',
                'description' => '',
                'color'       => '#E4AA8E',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 4,
                'parent'      => $this->getReference('esterenmaps-zonestypes-1'),
                'name'        => 'Domaine',
                'description' => '',
                'color'       => '#BBA748',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 5,
                'parent'      => $this->getReference('esterenmaps-zonestypes-1'),
                'name'        => 'Ville / Village',
                'description' => '',
                'color'       => '#F1E091',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 6,
                'parent'      => $this->getReference('esterenmaps-zonestypes-1'),
                'name'        => 'Terre sacrée',
                'description' => '',
                'color'       => '#CCA9D9',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 7,
                'parent_id'   => null,
                'name'        => 'Terrain',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 8,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Forêt',
                'description' => '',
                'color'       => '#669D4E',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 9,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Marais',
                'description' => '',
                'color'       => '#748F43',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 10,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Montagnes',
                'description' => '',
                'color'       => '#A6A6A6',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 11,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Failles / Falaises',
                'description' => '',
                'color'       => '#756098',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 12,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Landes',
                'description' => '',
                'color'       => '#9F8F50',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 13,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Mer, lac',
                'description' => '',
                'color'       => '#7099E4',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 14,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Île(s)',
                'description' => '',
                'color'       => '#6367AA',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 15,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Collines',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 16,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Plage(s)',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 17,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Plaine(s)',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 18,
                'parent'      => $this->getReference('esterenmaps-zonestypes-7'),
                'name'        => 'Plateau',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
        ];
    }
}

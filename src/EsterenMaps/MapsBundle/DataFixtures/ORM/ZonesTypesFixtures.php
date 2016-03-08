<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use EsterenMaps\MapsBundle\Entity\ZonesTypes;
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
     * Flush everytime to be sure that the references exist
     *
     * @return int
     */
    protected function flushEveryXIterations()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        return [
            [
                'id'          => 1,
                'parent'      => null,
                'name'        => 'Politique',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 2,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-1'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Royaume',
                'description' => '',
                'color'       => '#E05151',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 3,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-1'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Territoire',
                'description' => '',
                'color'       => '#E4AA8E',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 4,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-1'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Domaine',
                'description' => '',
                'color'       => '#BBA748',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 5,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-1'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Ville / Village',
                'description' => '',
                'color'       => '#F1E091',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 6,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-1'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Terre sacrée',
                'description' => '',
                'color'       => '#CCA9D9',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 7,
                'parent'      => null,
                'name'        => 'Terrain',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 8,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Forêt',
                'description' => '',
                'color'       => '#669D4E',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 9,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Marais',
                'description' => '',
                'color'       => '#748F43',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 10,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Montagnes',
                'description' => '',
                'color'       => '#A6A6A6',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 11,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Failles / Falaises',
                'description' => '',
                'color'       => '#756098',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 12,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Landes',
                'description' => '',
                'color'       => '#9F8F50',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 13,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Mer, lac',
                'description' => '',
                'color'       => '#7099E4',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 14,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Île(s)',
                'description' => '',
                'color'       => '#6367AA',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 15,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Collines',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 16,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Plage(s)',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 17,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
                'name'        => 'Plaine(s)',
                'description' => '',
                'color'       => '',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deleted_at'  => null,
            ],
            [
                'id'          => 18,
                'parent'      => function (ZonesTypes $obj, AbstractFixture $f, ObjectManager $manager) {
                    $ref = $manager->merge($f->getReference('esterenmaps-zonestypes-7'));
                    $obj->setParent($ref);

                    return $ref;
                },
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

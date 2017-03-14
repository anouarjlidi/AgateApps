<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Weapons;
use CorahnRin\CorahnRinBundle\Data\ItemAvailability;
use Orbitale\Component\DoctrineTools\AbstractFixture;
use Pierstoval\Bundle\ToolsBundle\Doctrine\FixtureMetadataIdGeneratorTrait;

class WeaponsFixtures extends AbstractFixture
{
    use FixtureMetadataIdGeneratorTrait;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Weapons::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        return [
            [
                'id'           => 1,
                'name'         => 'Dague,poignard,couteau',
                'description'  => '',
                'damage'       => 1,
                'price'        => 4,
                'availability' => ItemAvailability::FREQUENT,
                'melee'        => true,
                'range'        => 4,
            ],
            [
                'id'           => 2,
                'name'         => 'Fronde',
                'description'  => '',
                'damage'       => 1,
                'price'        => 2,
                'availability' => ItemAvailability::FREQUENT,
                'range'        => 8,
            ],
            [
                'id'           => 3,
                'name'         => 'Javelot',
                'description'  => '',
                'damage'       => 2,
                'price'        => 8,
                'availability' => ItemAvailability::COMMON,
                'melee'        => true,
                'range'        => 4,
            ],
            [
                'id'           => 4,
                'name'         => 'Arc',
                'description'  => '',
                'damage'       => 2,
                'price'        => 30,
                'availability' => ItemAvailability::FREQUENT,
                'range'        => 20,
            ],
            [
                'id'           => 5,
                'name'         => 'Arbalète',
                'description'  => '',
                'damage'       => 2,
                'price'        => 50,
                'availability' => ItemAvailability::COMMON,
                'range'        => 24,
            ],
            [
                'id'           => 6,
                'name'         => 'Francisque',
                'description'  => '',
                'damage'       => 2,
                'price'        => 20,
                'availability' => ItemAvailability::FREQUENT,
                'melee'        => true,
                'range'        => 2,
            ],
            [
                'id'           => 7,
                'name'         => 'Lance courte, épieu',
                'description'  => '',
                'damage'       => 2,
                'price'        => 20,
                'availability' => ItemAvailability::FREQUENT,
                'melee'        => true,
                'range'        => 3,
            ],
            [
                'id'           => 8,
                'name'         => 'Gourdin',
                'description'  => '',
                'damage'       => 1,
                'price'        => 2,
                'availability' => ItemAvailability::FREQUENT,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 9,
                'name'         => 'Marteau d\'artisan',
                'description'  => '',
                'damage'       => 2,
                'price'        => 10,
                'availability' => ItemAvailability::FREQUENT,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 10,
                'name'         => 'Masse d\'armes',
                'description'  => '',
                'damage'       => 2,
                'price'        => 20,
                'availability' => ItemAvailability::COMMON,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 11,
                'name'         => 'Carath',
                'description'  => '',
                'damage'       => 2,
                'price'        => 8,
                'availability' => ItemAvailability::FREQUENT,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 12,
                'name'         => 'Hache de bataille',
                'description'  => '',
                'damage'       => 3,
                'price'        => 50,
                'availability' => ItemAvailability::COMMON,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 13,
                'name'         => 'Epée longue droite Osag',
                'description'  => '',
                'damage'       => 3,
                'price'        => 70,
                'availability' => ItemAvailability::COMMON,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 14,
                'name'         => 'Glaive continental',
                'description'  => '',
                'damage'       => 2,
                'price'        => 50,
                'availability' => ItemAvailability::COMMON,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 15,
                'name'         => 'Arme d\'hast',
                'description'  => '',
                'damage'       => 3,
                'price'        => 80,
                'availability' => ItemAvailability::RARE,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 16,
                'name'         => 'Lance longue',
                'description'  => '',
                'damage'       => 3,
                'price'        => 40,
                'availability' => ItemAvailability::COMMON,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 17,
                'name'         => 'Marteau à deux mains',
                'description'  => '',
                'damage'       => 4,
                'price'        => 100,
                'availability' => ItemAvailability::RARE,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 18,
                'name'         => 'Claymore',
                'description'  => '',
                'damage'       => 4,
                'price'        => 100,
                'availability' => ItemAvailability::RARE,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 19,
                'name'         => 'Épée courte',
                'description'  => '',
                'damage'       => 2,
                'price'        => 50,
                'availability' => ItemAvailability::COMMON,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 20,
                'name'         => 'Épée longue',
                'description'  => '',
                'damage'       => 3,
                'price'        => 70,
                'availability' => ItemAvailability::FREQUENT,
                'melee'        => true,
                'range'        => 0,
            ],
            [
                'id'           => 21,
                'name'         => 'Arc court',
                'description'  => '',
                'damage'       => 2,
                'price'        => 30,
                'availability' => ItemAvailability::FREQUENT,
                'range'        => 20,
            ],
            [
                'id'           => 22,
                'name'         => 'Bâton',
                'description'  => '',
                'damage'       => 2,
                'price'        => 4,
                'availability' => ItemAvailability::FREQUENT,
                'melee'        => true,
                'range'        => 0,
            ],
        ];
    }
}

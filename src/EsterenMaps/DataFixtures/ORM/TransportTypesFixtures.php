<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Orbitale\Component\DoctrineTools\AbstractFixture;
use Agate\Doctrine\FixtureMetadataIdGeneratorTrait;
use EsterenMaps\Entity\TransportTypes;

class TransportTypesFixtures extends AbstractFixture implements ORMFixtureInterface
{
    use FixtureMetadataIdGeneratorTrait;

    /**
     * {@inheritdoc}
     */
    public function getOrder(): int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass(): string
    {
        return TransportTypes::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferencePrefix(): ?string
    {
        return 'esterenmaps-transports-';
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        return [
            [
                'id'          => 1,
                'name'        => 'Transport par défaut',
                'slug'        => 'transport-par-defaut',
                'description' => 'A pied + traversée maritime/fluviale',
                'speed'       => 4.5,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:25'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 2,
                'name'        => 'Chariot',
                'slug'        => 'chariot',
                'description' => '',
                'speed'       => 8,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 3,
                'name'        => 'Cheval',
                'slug'        => 'cheval',
                'description' => '',
                'speed'       => 12,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 4,
                'name'        => 'Caernide',
                'slug'        => 'caernide',
                'description' => '',
                'speed'       => 12,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 5,
                'name'        => 'Coracle (barque)',
                'slug'        => 'coracle',
                'description' => 'Moyen de transport fluvial/maritime',
                'speed'       => 4,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 12:24:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:15'),
                'deletedAt'   => null,
            ],
            [
                'id'          => 6,
                'name'        => 'Koggen (bateau)',
                'slug'        => 'koggen',
                'description' => 'Moyen de transport fluvial/maritime',
                'speed'       => 16,
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 12:25:11'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:09'),
                'deletedAt'   => null,
            ],
        ];
    }
}
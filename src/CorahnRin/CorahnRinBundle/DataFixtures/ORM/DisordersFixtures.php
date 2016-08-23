<?php

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Disorders;
use Orbitale\Component\DoctrineTools\AbstractFixture;
use Pierstoval\Bundle\ToolsBundle\Doctrine\FixtureMetadataIdGeneratorTrait;

class DisordersFixtures extends AbstractFixture
{
    use FixtureMetadataIdGeneratorTrait;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Disorders::class;
    }

    protected function getReferencePrefix()
    {
        return 'corahnrin-disorder-';
    }

    protected function getObjects()
    {
        $created = \DateTime::createFromFormat('Y-m-d H:i:s', '2014-04-09 08:56:43');

        return [
            [
                'id'          => 1,
                'name'        => 'Frénésie',
                'description' => '',
                'created'     => $created,
            ],
            [
                'id'          => 2,
                'name'        => 'Exaltation',
                'description' => '',
                'created'     => $created,
            ],
            [
                'id'          => 3,
                'name'        => 'Mélancolie',
                'description' => '',
                'created'     => $created,
            ],
            [
                'id'          => 4,
                'name'        => 'Hallucination',
                'description' => '',
                'created'     => $created,
            ],
            [
                'id'          => 5,
                'name'        => 'Confusion mentale',
                'description' => '',
                'created'     => $created,
            ],
            [
                'id'          => 6,
                'name'        => 'Mimétisme',
                'description' => '',
                'created'     => $created,
            ],
            [
                'id'          => 7,
                'name'        => 'Obsession',
                'description' => '',
                'created'     => $created,
            ],
            [
                'id'          => 8,
                'name'        => 'Hystérie',
                'description' => '',
                'created'     => $created,
            ],
            [
                'id'          => 9,
                'name'        => 'Mysticisme',
                'description' => '',
                'created'     => $created,
            ],
            [
                'id'          => 10,
                'name'        => 'Paranoïa',
                'description' => '',
                'created'     => $created,
            ],
        ];
    }
}

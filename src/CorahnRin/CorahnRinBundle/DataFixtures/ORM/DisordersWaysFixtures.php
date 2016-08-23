<?php

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\DisordersWays;
use Orbitale\Component\DoctrineTools\AbstractFixture;
use Pierstoval\Bundle\ToolsBundle\Doctrine\FixtureMetadataIdGeneratorTrait;

class DisordersWaysFixtures extends AbstractFixture
{
    use FixtureMetadataIdGeneratorTrait;

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return DisordersWays::class;
    }

    protected function getReferencePrefix()
    {
        return false;
    }

    protected function getObjects()
    {
        return [
            // 1 - Frénésie
            [
                'disorder' => $this->getReference('corahnrin-disorder-1'),
                'way'      => $this->getReference('corahnrin-way-1'),
                'isMajor'  => true,
            ],

            // 2 - Exaltation
            [
                'disorder' => $this->getReference('corahnrin-disorder-2'),
                'way'      => $this->getReference('corahnrin-way-1'),
                'isMajor'  => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-2'),
                'way'      => $this->getReference('corahnrin-way-5'),
                'isMajor'  => false,
            ],

            // 3 - Mélancolie
            [
                'disorder' => $this->getReference('corahnrin-disorder-3'),
                'way'      => $this->getReference('corahnrin-way-5'),
                'isMajor'  => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-3'),
                'way'      => $this->getReference('corahnrin-way-1'),
                'isMajor'  => false,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-3'),
                'way'      => $this->getReference('corahnrin-way-4'),
                'isMajor'  => false,
            ],

            // 4 - Hallucination
            [
                'disorder' => $this->getReference('corahnrin-disorder-4'),
                'way'      => $this->getReference('corahnrin-way-2'),
                'isMajor'  => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-4'),
                'way'      => $this->getReference('corahnrin-way-3'),
                'isMajor'  => true,
            ],

            // 5 - Confusion mentale
            [
                'disorder' => $this->getReference('corahnrin-disorder-5'),
                'way'      => $this->getReference('corahnrin-way-2'),
                'isMajor'  => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-5'),
                'way'      => $this->getReference('corahnrin-way-4'),
                'isMajor'  => false,
            ],

            // 6 - Mimétisme
            [
                'disorder' => $this->getReference('corahnrin-disorder-6'),
                'way'      => $this->getReference('corahnrin-way-2'),
                'isMajor'  => false,
            ],

            // 7 - Obsession
            [
                'disorder' => $this->getReference('corahnrin-disorder-7'),
                'way'      => $this->getReference('corahnrin-way-4'),
                'isMajor'  => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-7'),
                'way'      => $this->getReference('corahnrin-way-2'),
                'isMajor'  => false,
            ],

            // 8 - Hystérie
            [
                'disorder' => $this->getReference('corahnrin-disorder-8'),
                'way'      => $this->getReference('corahnrin-way-3'),
                'isMajor'  => true,
            ],

            // 9 - Mysticisme
            [
                'disorder' => $this->getReference('corahnrin-disorder-9'),
                'way'      => $this->getReference('corahnrin-way-3'),
                'isMajor'  => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-9'),
                'way'      => $this->getReference('corahnrin-way-5'),
                'isMajor'  => true,
            ],

            // 10 - Paranoïa
            [
                'disorder' => $this->getReference('corahnrin-disorder-10'),
                'way'      => $this->getReference('corahnrin-way-4'),
                'isMajor'  => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-10'),
                'way'      => $this->getReference('corahnrin-way-3'),
                'isMajor'  => false,
            ],
        ];
    }
}

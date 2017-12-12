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

use CorahnRin\CorahnRinBundle\Entity\DisordersWays;
use Orbitale\Component\DoctrineTools\AbstractFixture;
use Pierstoval\Bundle\ToolsBundle\Doctrine\FixtureMetadataIdGeneratorTrait;

class DisordersWaysFixtures extends AbstractFixture
{
    use FixtureMetadataIdGeneratorTrait;

    /**
     * {@inheritdoc}
     */
    public function getOrder(): int
    {
        return 3;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass(): string
    {
        return DisordersWays::class;
    }

    protected function getReferencePrefix(): ?string
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
                'major'    => true,
            ],

            // 2 - Exaltation
            [
                'disorder' => $this->getReference('corahnrin-disorder-2'),
                'way'      => $this->getReference('corahnrin-way-1'),
                'major'    => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-2'),
                'way'      => $this->getReference('corahnrin-way-5'),
                'major'    => false,
            ],

            // 3 - Mélancolie
            [
                'disorder' => $this->getReference('corahnrin-disorder-3'),
                'way'      => $this->getReference('corahnrin-way-5'),
                'major'    => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-3'),
                'way'      => $this->getReference('corahnrin-way-1'),
                'major'    => false,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-3'),
                'way'      => $this->getReference('corahnrin-way-4'),
                'major'    => false,
            ],

            // 4 - Hallucination
            [
                'disorder' => $this->getReference('corahnrin-disorder-4'),
                'way'      => $this->getReference('corahnrin-way-2'),
                'major'    => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-4'),
                'way'      => $this->getReference('corahnrin-way-3'),
                'major'    => true,
            ],

            // 5 - Confusion mentale
            [
                'disorder' => $this->getReference('corahnrin-disorder-5'),
                'way'      => $this->getReference('corahnrin-way-2'),
                'major'    => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-5'),
                'way'      => $this->getReference('corahnrin-way-4'),
                'major'    => false,
            ],

            // 6 - Mimétisme
            [
                'disorder' => $this->getReference('corahnrin-disorder-6'),
                'way'      => $this->getReference('corahnrin-way-2'),
                'major'    => false,
            ],

            // 7 - Obsession
            [
                'disorder' => $this->getReference('corahnrin-disorder-7'),
                'way'      => $this->getReference('corahnrin-way-4'),
                'major'    => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-7'),
                'way'      => $this->getReference('corahnrin-way-2'),
                'major'    => false,
            ],

            // 8 - Hystérie
            [
                'disorder' => $this->getReference('corahnrin-disorder-8'),
                'way'      => $this->getReference('corahnrin-way-3'),
                'major'    => true,
            ],

            // 9 - Mysticisme
            [
                'disorder' => $this->getReference('corahnrin-disorder-9'),
                'way'      => $this->getReference('corahnrin-way-3'),
                'major'    => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-9'),
                'way'      => $this->getReference('corahnrin-way-5'),
                'major'    => true,
            ],

            // 10 - Paranoïa
            [
                'disorder' => $this->getReference('corahnrin-disorder-10'),
                'way'      => $this->getReference('corahnrin-way-4'),
                'major'    => true,
            ],
            [
                'disorder' => $this->getReference('corahnrin-disorder-10'),
                'way'      => $this->getReference('corahnrin-way-3'),
                'major'    => false,
            ],
        ];
    }
}

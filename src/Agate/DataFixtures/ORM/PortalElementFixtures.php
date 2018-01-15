<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\DataFixtures\ORM;

use Agate\Entity\PortalElement;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Orbitale\Component\DoctrineTools\AbstractFixture;

final class PortalElementFixtures extends AbstractFixture implements ORMFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getEntityClass(): string
    {
        return PortalElement::class;
    }

    protected function searchForMatchingIds(): bool
    {
        return false;
    }

    protected function setGeneratorBasedOnId(ClassMetadata $metadata, $id = null): void
    {
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_AUTO);
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        return [
            [
                'id' => 1,
                'portal' => 'esteren',
                'locale' => 'fr',
                'imageUrl' => 'maps/esteren_map.jpg',
                'title' => 'Portail Esteren',
                'subtitle' => 'sub',
                'buttonText' => 'button',
                'buttonLink' => '/',
            ],
            [
                'portal' => 'esteren',
                'locale' => 'en',
                'imageUrl' => 'maps/esteren_map.jpg',
                'title' => 'Esteren Portal',
                'subtitle' => 'sub',
                'buttonText' => 'button',
                'buttonLink' => '/',
            ],
            [
                'portal' => 'agate',
                'locale' => 'fr',
                'imageUrl' => 'maps/esteren_map.jpg',
                'title' => 'Portail Agate',
                'subtitle' => 'sub',
                'buttonText' => 'button',
                'buttonLink' => '/',
            ],
            [
                'portal' => 'agate',
                'locale' => 'en',
                'imageUrl' => 'maps/esteren_map.jpg',
                'title' => 'Agate Portal',
                'subtitle' => 'sub',
                'buttonText' => 'button',
                'buttonLink' => '/',
            ],
        ];
    }
}

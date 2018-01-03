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
use Orbitale\Component\DoctrineTools\AbstractFixture;

class PortalElementFixtures extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    protected function getEntityClass(): string
    {
        return PortalElement::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        return [
            [
                'host' => 'portal.esteren.dev',
                'locale' => 'fr',
                'imageUrl' => '',
                'title' => '',
                'subtitle' => '',
                'buttonText' => '',
            ]
        ];
    }
}

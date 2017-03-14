<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\CombatArts;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;

final class CombatArtsRepository extends BaseEntityRepository
{
    /**
     * @return CombatArts[]
     */
    public function findAllSortedByName()
    {
        return $this->createQueryBuilder('combat_art', 'combat_art.id')
            ->from($this->_entityName, 'combat_arts', 'combat_arts.id')
            ->orderBy('combat_arts.name', 'asc')
            ->getQuery()->getResult()
        ;
    }
}

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

use CorahnRin\CorahnRinBundle\Entity\Weapons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

final class WeaponsRepository extends ServiceEntityRepository
{
    /**
     * @return Weapons[]
     */
    public function findAllSortedByName()
    {
        return $this->_em->createQueryBuilder()
            ->select('weapon')
            ->from($this->_entityName, 'weapon', 'weapon.id')
            ->orderBy('weapon.name', 'asc')
            ->getQuery()->getResult()
        ;
    }
}

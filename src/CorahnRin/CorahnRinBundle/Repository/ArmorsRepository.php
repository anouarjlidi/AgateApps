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

use CorahnRin\CorahnRinBundle\Entity\Armors;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;

final class ArmorsRepository extends BaseEntityRepository
{
    /**
     * @return Armors[]
     */
    public function findAllSortedByName()
    {
        return $this->_em->createQueryBuilder()
            ->select('armor')
            ->from($this->_entityName, 'armor', 'armor.id')
            ->orderBy('armor.name', 'asc')
            ->getQuery()->getResult()
        ;
    }
}

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

use CorahnRin\CorahnRinBundle\Entity\Disciplines;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class DisciplinesRepository extends BaseRepository
{
    /**
     * @param int[] $domainsIds
     *
     * @return Disciplines[]
     */
    public function findAllByDomains(array $domainsIds)
    {
        return $this->createQueryBuilder('discipline', 'discipline.id')
            ->from($this->_entityName, 'disciplines', 'disciplines.id')
            ->leftJoin('discipline.domains', 'domain')
            ->where('domain.id in (:ids)')
            ->setParameter('ids', $domainsIds)
            ->orderBy('disciplines.name', 'asc')
            ->getQuery()->getResult()
        ;
    }
}

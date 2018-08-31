<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Repository;

use CorahnRin\Entity\Disciplines;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DisciplinesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Disciplines::class);
    }

    /**
     * @param int[] $domainsIds
     *
     * @return Disciplines[]
     */
    public function findAllByDomains(array $domainsIds)
    {
        return $this->createQueryBuilder('discipline', 'discipline.id')
            ->from($this->_entityName, 'disciplines', 'disciplines.id')
            ->where('discipline.domains in (:ids)')// TODO: Fix this part
            ->setParameter('ids', $domainsIds)
            ->orderBy('disciplines.name', 'asc')
            ->getQuery()->getResult()
        ;
    }
}

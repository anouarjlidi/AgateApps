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

use CorahnRin\CorahnRinBundle\Entity\Domains;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DomainsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Domains::class);
    }

    /**
     * @return Domains[]
     */
    public function findAllSortedByName()
    {
        return $this->createQueryBuilder('domain', 'domain.id')
            ->from($this->_entityName, 'domains', 'domains.id')
            ->orderBy('domains.name', 'asc')
            ->getQuery()->getResult()
        ;
    }
}

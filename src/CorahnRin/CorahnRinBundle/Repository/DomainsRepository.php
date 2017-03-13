<?php

namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\Domains;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class DomainsRepository extends BaseRepository
{
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

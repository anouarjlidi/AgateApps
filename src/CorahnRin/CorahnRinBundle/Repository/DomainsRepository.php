<?php

namespace CorahnRin\CorahnRinBundle\Repository;

use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class DomainsRepository extends BaseRepository
{
    /**
     * @return string[]
     */
    public function findAllSortedByName()
    {
        $data = $this->_em
            ->createQueryBuilder()
            ->select('domains.name as name')
            ->from($this->_entityName, 'domains')
            ->orderBy('domains.name', 'asc')
            ->getQuery()->getArrayResult()
        ;

        foreach ($data as $id => $element) {
            yield $id => $element['name'];
        }
    }
}

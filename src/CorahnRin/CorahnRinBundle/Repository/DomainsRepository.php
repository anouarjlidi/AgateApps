<?php
namespace CorahnRin\CorahnRinBundle\Repository;

use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

/**
 * DomainsRepository
 *
 */
class DomainsRepository extends BaseRepository
{

    /**
     * Renvoie la liste de tous les noms de Domains triés par ID
     * @return array
     */
    public function findAllSortedByName()
    {
        $datas = $this->_em
            ->createQueryBuilder()
            ->select('domains.name as name')
            ->from($this->_entityName, 'domains')
            ->orderBy('domains.name', 'asc')
            ->getQuery()->getArrayResult()
        ;
        foreach ($datas as $id => $element) {
            $datas[$id] = $element['name'];
        }
        return $datas;
    }

}

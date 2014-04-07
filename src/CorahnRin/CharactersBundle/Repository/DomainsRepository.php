<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * DomainsRepository
 *
 */
class DomainsRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->_em->createQueryBuilder()
            ->select('p')
            ->from($this->_entityName, 'p')
            ->leftJoin('p.way', 'c')
                ->addSelect('c')
            ->leftJoin('p.disciplines', 'd')
                ->addSelect('d')
            ->leftJoin('d.book', 'b')
                ->addSelect('b')
        ;
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }

    public function findAllSortedByName(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null, $sortCollection = true) {
        $orderBy = array('p.name'=>'asc');
        $datas = $this->findBy($criteria, $orderBy, $limit, $offset, $sortCollection);
        foreach ($datas as $id => $element) {
            $datas[$id] = $element->getName();
        }
        return $datas;
    }
}
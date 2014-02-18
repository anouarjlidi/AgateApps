<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * CharactersRepository
 *
 */
class CharactersRepository extends CorahnRinRepository {

    public function findSearch($searchField = 'id', $order = 'asc', $limit = 20, $offset = 0, $getCount = false) {

        $qb = $this->_em->createQueryBuilder()->select('a');

        if ($getCount) {
            $qb->addSelect('count(a) as number');
        }

        $qb
            ->from($this->_entityName, 'a')
            ->where('a.deleted = 0')
            ->leftJoin('a.job', 'b')
                ->addSelect('b')
            ->leftJoin('a.people', 'c')
                ->addSelect('c')
            ->leftJoin('a.region', 'd')
                ->addSelect('d')
        ;

        if ($searchField === 'job') {
            $qb ->addOrderBy('b.name', $order)
                ->addOrderBy('a.jobCustom', $order);
        } elseif ($searchField === 'people') {
            $qb->orderBy('c.name');
        } elseif ($searchField === 'region') {
            $qb->orderBy('d.name');
        } else {
            $qb->orderBy('a.'.$searchField, $order);
        }

        if (!$getCount) {
            $qb->setFirstResult($offset);
            $qb->setMaxResults($limit);
        }

        if ($getCount) {
            $datas = $qb->getQuery()->getScalarResult();
            $datas = $datas[0]['number'];
        } else {
            $datas = $qb->getQuery()->getResult();
        }

        return $datas;
    }

    public function getNumberOfElementsSearch($searchField = 'id', $order = 'asc', $limit = 20, $offset = 0) {
        return $this->findSearch($searchField, $order, $limit, $offset, true);
    }

}
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
        ;
        foreach ($criteria as $field => $value) {
            $qb->where('p.'.$field.' = :'.$field)
               ->setParameter($field, $value);
        }
        if (is_string($orderBy)) {
            $qb->orderBy($orderBy);
        } elseif (is_array($orderBy)) {
            foreach ($orderBy as $field => $order) {
                $qb->orderBy($field, $order);
            }
        }

        if (null !== $offset) { $qb->setFirstResult($offset); }
        if (null !== $limit) { $qb->setMaxResults($limit); }

        $datas = $qb->getQuery()->getResult();

        if ($sortCollection) {
            $datas = $this->sortCollection($datas);
        }

        return $datas;
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
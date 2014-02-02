<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * AvantagesRepository
 *
 */
class AvantagesRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->_em->createQueryBuilder()
            ->select('p')
            ->from($this->_entityName, 'p')
            ->leftJoin('p.book', 'b')
                ->addSelect('b')
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

    function findAllDifferenciated() {
        $list = $this->findAll();
        $advantages = $disadvantages = array();
        foreach ($list as $id => $element) {
            if ($element->getIsDesv()) {
                $disadvantages[$id] = $element;
            } else {
                $advantages[$id] = $element;
            }
        }
        return array(
            'advantages' => $advantages,
            'disadvantages' => $disadvantages,
        );
    }

}
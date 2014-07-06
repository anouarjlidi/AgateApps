<?php

namespace EsterenMaps\MapsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use EsterenMaps\MapsBundle\Entity\ZonesTypes;

/**
 * ZonesTypesRepository
 */
class ZonesTypesRepository extends EntityRepository {

    /**
     * @return ZonesTypes[]
     */
    public function findForAdmin() {
        $qb = $this->_em
            ->createQueryBuilder()
            ->select('zonesTypes')
            ->from($this->_entityName, 'zonesTypes')
            ->leftJoin('zonesTypes.parent', 'parent0')
            ->addSelect('parent0');

        for ($i = 0; $i < 10; $i++) {
            $qb->leftJoin('parent'.$i.'.parent', 'parent'.($i + 1))
               ->addSelect('parent'.($i + 1));
        }

        $qb->addOrderBy('zonesTypes.parent', 'asc');
        $qb->addOrderBy('zonesTypes.id', 'asc');

        $list = $qb->getQuery()->getResult();

        return $this->orderTree(0, $list);
    }

    /**
     * Trie récursivement les liens de menu
     * @param int $level
     * @param ZonesTypes[] $list
     * @return ZonesTypes[]
     */
    public function orderTree($level,$list) {
        $elements = array();
        foreach ($list as $element) {
            $parent = $element->getParent() ? $element->getParent()->getId() : 0;
            if ($parent == $level) {
                $element->setChildren($this->orderTree($element->getId(), $list));
                $elements[$element->getId()] = $element;
            }
        }
        return $elements;
    }
}

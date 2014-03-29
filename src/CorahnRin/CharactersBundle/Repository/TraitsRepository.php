<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository;

/**
 * TraitsRepository
 *
 */
class TraitsRepository extends CorahnRinRepository {

    function findAllDifferenciated() {
        $list = $this->findBy(array(), array('name'=>'asc'), null, null, true);
        $qualities = $defaults = array();
        foreach ($list as $id => $element) {
            if (!$element->getIsQuality()) {
                $defaults[$id] = $element;
            } else {
                $qualities[$id] = $element;
            }
        }
        return array(
            'qualities' => $qualities,
            'defaults' => $defaults,
        );
    }

    /**
     * Récupère les données à partir des voies.
     * ATTENTION :
     * Le tableau $ways DOIT être structuré de cette façon :
     * (key) wayid => (value) way score
     * @param array $ways
     */
    function findAllDependingOnWays(array $ways) {
        $qb = $this->_em->createQueryBuilder()
            ->select('t')
            ->from($this->_entityName, 't')
            ->leftJoin('t.ways', 'w')
                ->addSelect('w')
        ;
        foreach ($ways as $id => $value) {
            $qb->where('p.way = '.$id)
                ;
        }
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }
}
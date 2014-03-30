<?php
namespace CorahnRin\CharactersBundle\Repository;

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
            'flaws' => $defaults,
        );
    }

    function sortQualitiesFlaws($traits) {
        $list = array('qualities'=>array(),'flaws'=>array());
        foreach ($traits as $trait) {
            if ($trait->getIsQuality()) {
                $list['qualities'][$trait->getId()] = $trait;
            } else {
                $list['flaws'][$trait->getId()] = $trait;
            }
        }
        return $list;
    }

    /**
     * Récupère les données à partir des voies.
     * ATTENTION :
     * Le tableau $ways DOIT être structuré de cette façon :
     * (key) wayid => (value) way score
     * @param array $ways
     * @return array
     */
    function findAllDependingOnWays(array $ways) {
        $qb = $this->_em->createQueryBuilder()
            ->select('t')
            ->from($this->_entityName, 't')
            ->leftJoin('t.way', 'w')
                ->addSelect('w')
        ;
        foreach ($ways as $id => $value) {
            if ($id >= 4 || $id <= 2) {
                $qb->orWhere('w.id = :way'.$id.' AND t.isMajor = :way'.$id.'major')
                    ->setParameter(':way'.$id, $id)
                    ->setParameter(':way'.$id.'major', $value >= 4)
                ;
            }
        }

        $list = $this->defaultFindBy($qb, array(), array('t.name'=>'asc'), null, null, false);

        return $this->sortQualitiesFlaws($list);
    }
}
<?php
namespace CorahnRin\ModelsBundle\Repository;

use CorahnRin\ModelsBundle\Entity\Traits;
use CorahnRin\ModelsBundle\Entity\Ways;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository;

/**
 * TraitsRepository
 *
 */
class TraitsRepository extends CorahnRinRepository {

    /**
     * @return array
     */
    function findAllDifferenciated() {
        $list = $this->findBy(array(), array('name' => 'asc'), null, null, true);
        $qualities = $flaws = array();
        foreach ($list as $id => $element) {
            if ($element instanceof Traits) {
                if (!$element->getIsQuality()) {
                    $flaws[$id] = $element;
                } else {
                    $qualities[$id] = $element;
                }
            }
        }
        return array(
            'qualities' => $qualities,
            'flaws' => $flaws,
        );
    }

    /**
     * @param Traits[] $traits
     * @return array
     */
    function sortQualitiesFlaws($traits) {
        $list = array('qualities' => array(), 'flaws' => array());
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
     * @param Ways[] $ways
     * @throws \Exception
     * @return Traits[]
     */
    function findAllDependingOnWays(array $ways) {
        $qb = $this->_em
            ->createQueryBuilder()
            ->select('t')
            ->from($this->_entityName, 't')
            ->leftJoin('t.way', 'w')
            ->addSelect('w');
        foreach ($ways as $id => $value) {
            if (!is_numeric($id) || !is_numeric($value)) {
                throw new \Exception('Error in ways values. Must be equivalent to this : array( [WAY_ID] => [WAY_VALUE] )');
            }
            if ($id >= 4 || $id <= 2) {
                $qb->orWhere('w.id = :way' . $id . ' AND t.isMajor = :way' . $id . 'major')
                   ->setParameter(':way' . $id, $id)
                   ->setParameter(':way' . $id . 'major', $value >= 4);
            }
        }

        $qb->orderBy('t.name', 'asc');

        $list = $qb->getQuery()->getResult();

        return $this->sortQualitiesFlaws($list);
    }
}
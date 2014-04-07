<?php
namespace CorahnRin\GeneratorBundle\Repository;

use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * StepsRepository
 *
 */
class StepsRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->_em->createQueryBuilder()
            ->select('a')
            ->from($this->_entityName, 'a')
            ->leftJoin('a.stepsToDisableOnChange', 'b')
                ->addSelect('b')
        ;
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }

}
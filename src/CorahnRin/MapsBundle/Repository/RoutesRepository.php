<?php
namespace CorahnRin\MapsBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * RoutesRepository
 *
 */
class RoutesRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->_em->createQueryBuilder()
            ->select('r')
            ->from($this->_entityName, 'r')
            ->leftJoin('r.routeType', 't')
                ->addSelect('t')
        ;
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }

}
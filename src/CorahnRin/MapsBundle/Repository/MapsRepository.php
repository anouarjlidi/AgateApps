<?php
namespace CorahnRin\MapsBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * MapsRepository
 *
 */
class MapsRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->_em->createQueryBuilder()
            ->select('p')
            ->from($this->_entityName, 'p')
            ->leftJoin('p.zones', 'z')
                ->addSelect('z')
            ->leftJoin('p.markers', 'm')
                ->addSelect('m')
            ->leftJoin('p.routes', 'r')
                ->addSelect('r')
        ;
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }

}
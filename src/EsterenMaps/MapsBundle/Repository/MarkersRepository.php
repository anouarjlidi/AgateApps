<?php
namespace EsterenMaps\MapsBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * MarkersRepository
 *
 */
class MarkersRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->_em->createQueryBuilder()
            ->select('m')
            ->from($this->_entityName, 'm')
            ->leftJoin('m.markerType', 't')
                ->addSelect('t')
        ;
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }

}
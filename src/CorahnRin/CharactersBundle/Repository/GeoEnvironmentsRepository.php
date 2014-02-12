<?php
namespace Corahnrin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * GeoEnvironmentsRepository
 *
 */
class GeoEnvironmentsRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->_em->createQueryBuilder()
            ->select('g')
            ->from($this->_entityName, 'g')
            ->leftJoin('g.book', 'b')
                ->addSelect('b')
            ->leftJoin('g.domain', 'd')
                ->addSelect('d')
        ;
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }

}
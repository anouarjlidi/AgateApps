<?php
namespace CorahnRin\CharactersBundle\Repository;

use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * SocialClassesRepository
 *
 */
class SocialClassesRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->_em->createQueryBuilder()
            ->select('s')
            ->from($this->_entityName, 's')
            ->leftJoin('s.domains', 'd')
                ->addSelect('d')
        ;
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }
}
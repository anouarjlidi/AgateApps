<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * ArtifactsRepository
 *
 */
class ArtifactsRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->_em->createQueryBuilder()
            ->select('p')
            ->from($this->_entityName, 'p')
            ->leftJoin('p.flux', 'c')
                ->addSelect('c')
        ;
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }

}
<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * JobsRepository
 *
 */
class JobsRepository extends CorahnRinRepository {

//    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
//        $qb = $this->_em->createQueryBuilder()
//            ->select('p')
//            ->from($this->_entityName, 'p')
//            ->leftJoin('p.domainPrimary', 'd1')
//                ->addSelect('d1')
//            ->leftJoin('p.domainsSecondary', 'd2')
//                ->addSelect('d1')
//            ->leftJoin('p.book', 'b')
//                ->addSelect('b')
//        ;
//        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
//    }

    public function findAllPerBook($format = true) {
        $jobs = $this->findAll($format);
        $jobs_ordered = array();
        foreach ($jobs as $job) {
            $jobs_ordered[$job->getBook()->getId()][] = $job;
        }
        return $jobs_ordered;
    }
}
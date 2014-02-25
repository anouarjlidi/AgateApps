<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * CharactersRepository
 *
 */
class CharactersRepository extends CorahnRinRepository {

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $qb = $this->getQb();
        return $this->defaultFindBy($qb, $criteria, $orderBy, $limit, $offset, $sortCollection);
    }

    private function getQb() {
        $qb = $this->_em->createQueryBuilder()
            ->select('a')
            ->from($this->_entityName, 'a')
            ->where('a.deleted = 0')
            ->leftJoin('a.job', 'j')
                ->addSelect('j')
            ->leftJoin('a.ways', 'w')
                ->addSelect('w')
            ->leftJoin('a.people', 'peo')
                ->addSelect('peo')
            ->leftJoin('a.region', 'reg')
                ->addSelect('reg')
            ->leftJoin('a.armors', 'arm')
                ->addSelect('arm')
            ->leftJoin('a.weapons', 'wea')
                ->addSelect('wea')
            ->leftJoin('a.artifacts', 'art')
                ->addSelect('art')
            ->leftJoin('a.flux', 'fl')
                ->addSelect('fl')
            ->leftJoin('a.miracles', 'mir')
                ->addSelect('mir')
            ->leftJoin('a.domains', 'dom')
                ->addSelect('dom')
            ->leftJoin('a.disciplines', 'disc')
                ->addSelect('disc')
            ->leftJoin('a.avantages', 'avtg')
                ->addSelect('avtg')
        ;
        return $qb;
    }

    public function findSearch($searchField = 'id', $order = 'asc', $limit = 20, $offset = 0, $getCount = false) {

        $qb = $this->_em->createQueryBuilder()
            ->select('a')
            ->from($this->_entityName, 'a')
            ->where('a.deleted = 0')
            ->leftJoin('a.job', 'j')
                ->addSelect('j')
            ->leftJoin('a.people', 'peo')
                ->addSelect('peo')
            ->leftJoin('a.region', 'reg')
                ->addSelect('reg')
        ;

        if ($getCount) {
            $qb->addSelect('count(a) as number');
        }

        if ($searchField === 'job') {
            $qb ->addOrderBy('j.name', $order)
                ->addOrderBy('a.jobCustom', $order);
        } elseif ($searchField === 'people') {
            $qb->orderBy('peo.name');
        } elseif ($searchField === 'region') {
            $qb->orderBy('reg.name');
        } else {
            $qb->orderBy('a.'.$searchField, $order);
        }

        if (!$getCount) {
            $qb->setFirstResult($offset);
            $qb->setMaxResults($limit);
        }

        if ($getCount) {
            $datas = $qb->getQuery()->getScalarResult();
            $datas = $datas[0]['number'];
        } else {
            $datas = $qb->getQuery()->getResult();
        }

        return $datas;
    }

    public function getNumberOfElementsSearch($searchField = 'id', $order = 'asc', $limit = 20, $offset = 0) {
        return $this->findSearch($searchField, $order, $limit, $offset, true);
    }

}
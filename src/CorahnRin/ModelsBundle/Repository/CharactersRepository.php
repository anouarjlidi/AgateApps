<?php
namespace CorahnRin\ModelsBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * CharactersRepository
 *
 */
class CharactersRepository extends CorahnRinRepository {

    private function getQb() {
        $qb = $this->_em->createQueryBuilder()
            ->select('characters')
            ->from($this->_entityName, 'characters')
            ->leftJoin('characters.job', 'job')->addSelect('job')
            ->leftJoin('characters.ways', 'ways')->addSelect('ways')
            ->leftJoin('characters.people', 'people')->addSelect('people')
            ->leftJoin('characters.region', 'region')->addSelect('region')
            ->leftJoin('characters.armors', 'armors')->addSelect('armors')
            ->leftJoin('characters.weapons', 'weapons')->addSelect('weapons')
            ->leftJoin('characters.artifacts', 'artifacts')->addSelect('artifacts')
            ->leftJoin('characters.flux', 'flux')->addSelect('flux')
            ->leftJoin('characters.miracles', 'miracles')->addSelect('miracles')
            ->leftJoin('characters.domains', 'domains')->addSelect('domains')
            ->leftJoin('characters.disciplines', 'disciplines')->addSelect('disciplines')
            ->leftJoin('characters.avantages', 'avantages')->addSelect('avantages')
        ;
        return $qb;
    }

    public function findSearch($searchField = 'id', $order = 'asc', $limit = 20, $offset = 0, $getCount = false) {

        $qb = $this->_em->createQueryBuilder()
            ->select('characters')
            ->from($this->_entityName, 'characters')
            ->leftJoin('characters.job', 'job')->addSelect('job')
            ->leftJoin('characters.people', 'people')->addSelect('people')
            ->leftJoin('characters.region', 'region')->addSelect('region')
        ;

        if ($getCount) {
            $qb->addSelect('count(characters) as number');
        }

        if ($searchField === 'job') {
            $qb ->addOrderBy('job.name', $order)
                ->addOrderBy('characters.jobCustom', $order);
        } elseif ($searchField === 'people') {
            $qb->orderBy('people.name');
        } elseif ($searchField === 'region') {
            $qb->orderBy('region.name');
        } else {
            $qb->orderBy('characters.'.$searchField, $order);
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
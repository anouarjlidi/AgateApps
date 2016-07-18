<?php

namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\Characters;
use Doctrine\ORM\QueryBuilder;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class CharactersRepository extends BaseRepository
{
    /**
     * Get a Characters object with all its data.
     *
     * @param int $id
     *
     * @return Characters|null
     */
    public function findFetched($id)
    {
        return $this->_em
            ->createQueryBuilder()
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
            ->where('characters.id = :id')
                ->setParameter('id', (int) $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param string $searchField Le champ dans lequel exécuter la requête
     * @param string $order       L'ordre (asc ou desc)
     * @param int    $limit       Le nombre d'éléments à récupérer
     * @param int    $offset      L'offset de départ
     *
     * @return QueryBuilder
     */
    public function searchQueryBuilder($searchField = 'id', $order = null, $limit = null, $offset = null)
    {
        $qb = $this->_em
            ->createQueryBuilder()
            ->select('characters')
            ->from($this->_entityName, 'characters')
            ->leftJoin('characters.job', 'job')->addSelect('job')
            ->leftJoin('characters.people', 'people')->addSelect('people')
            ->leftJoin('characters.region', 'region')->addSelect('region')
        ;

        if (null !== $searchField && null !== $order) {
            if ($searchField === 'job') {
                $qb
                    ->addOrderBy('job.name', $order)
                    ->addOrderBy('characters.jobCustom', $order)
                ;
            } elseif ($searchField === 'people') {
                $qb->orderBy('people.name');
            } elseif ($searchField === 'region') {
                $qb->orderBy('region.name');
            } else {
                $qb->orderBy('characters.'.$searchField, $order);
            }
        }

        if (null !== $offset) {
            $qb->setFirstResult($offset);
        }

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb;
    }

    /**
     * @param string $searchField
     * @param string $order
     * @param int    $limit
     * @param int    $offset
     *
     * @return Characters[]
     */
    public function findSearch($searchField = 'id', $order = 'asc', $limit = 20, $offset = 0)
    {
        return $this
            ->searchQueryBuilder($searchField, $order, $limit, $offset)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param string $searchField
     * @param string $order
     *
     * @return int
     */
    public function countSearch($searchField = 'id', $order = 'asc')
    {
        return (int) $this
            ->searchQueryBuilder($searchField, $order)
            ->select('count (characters.id) as number')
            ->getQuery()
            ->getScalarResult()[0]['number']
        ;
    }
}

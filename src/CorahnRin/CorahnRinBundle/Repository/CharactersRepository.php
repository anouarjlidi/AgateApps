<?php
namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\Characters;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

/**
 * CharactersRepository
 *
 */
class CharactersRepository extends BaseRepository
{

    /**
     * @param $id
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
            ->getOneOrNullResult();
    }

    /**
     * @param string $searchField Le champ dans lequel exécuter la requête
     * @param string $order       L'ordre (asc ou desc)
     * @param int    $limit       Le nombre d'éléments à récupérer
     * @param int    $offset      L'offset de départ
     * @param bool   $getCount    Récupérer uniquement le nombre de résultats totaux (sans les informations "limit" et
     *                            "offset")
     *
     * @return Characters[]
     */
    public function findSearch($searchField = 'id', $order = 'asc', $limit = 20, $offset = 0, $getCount = false)
    {

        $qb = $this->_em
            ->createQueryBuilder()
            ->select('characters')
            ->from($this->_entityName, 'characters')
            ->leftJoin('characters.job', 'job')->addSelect('job')
            ->leftJoin('characters.people', 'people')->addSelect('people')
            ->leftJoin('characters.region', 'region')->addSelect('region');

        if ($getCount) {
            $qb->addSelect('count(characters) as number');
        }

        if ($searchField === 'job') {
            $qb->addOrderBy('job.name', $order)
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

    /**
     * @param string $searchField
     * @param string $order
     * @param int    $limit
     * @param int    $offset
     *
     * @return Characters[]
     */
    public function getNumberOfElementsSearch($searchField = 'id', $order = 'asc', $limit = 20, $offset = 0)
    {
        return $this->findSearch($searchField, $order, $limit, $offset, true);
    }

}
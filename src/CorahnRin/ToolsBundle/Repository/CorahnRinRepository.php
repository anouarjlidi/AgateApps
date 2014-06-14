<?php

namespace CorahnRin\ToolsBundle\Repository;

use Doctrine\ORM\EntityRepository as EntityRepository;
use Doctrine\ORM\Query;

/**
 * CorahnRinRepository
 * Gestionnaire de repositories de Corahn-Rin
 */
abstract class CorahnRinRepository extends EntityRepository {

    /**
     * Finds entities by a set of criteria.
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @param bool $sortCollection Sort collection with primary key if set to "true"
     * @return array The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        $datas = parent::findBy($criteria, $orderBy, $limit, $offset);
        if ($datas && $sortCollection === true) {
            $datas = $this->sortCollection($datas);
        }
        return $datas;
    }

    /**
     * Finds all entities in the repository.
     *
     * @param bool $sortCollection Sort collection with primary key if set to "true"
     * @return array The entities.
     */
    public function findAll($sortCollection = false) {
        $datas = $this->findBy(array());

        if ($datas && $sortCollection === true) {
            $datas = $this->sortCollection($datas);
        }

        return $datas;
    }

    /**
     * Alias de getMax()
     * @see getMax()
     * @return int
     */
    public function getAutoIncrement() {
        return $this->getMax();
    }

    public function getNumberOfElements() {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(a)')
           ->where('a.deleted = 0')
           ->from($this->getEntityName(), 'a');

        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }

    /**
     * Récupère la valeur de l'AUTO_INCREMENT de la table de l'entité
     * @return int
     */
    public function getMax() {
        $table = $this->getClassMetadata()->getTableName();

        $connection = $this->getEntityManager()->getConnection();
        $statement = $connection->prepare('SHOW TABLE STATUS LIKE "' . $table . '" ');
        $statement->execute();
        $datas = $statement->fetch();

        $max = (int)$datas['Auto_increment'];

        return $max;
    }

    public function sortCollection($collection, $by = '_primary') {
        $total = array();
        $current = current($collection);
        if ('_primary' === $by) {
            $by = $this->getClassMetadata()->getSingleIdentifierFieldName();
        }
        if (property_exists($current, $by)) {
            foreach ($collection as $entity) {
                $total[$entity->{'get' . ucfirst($by)}()] = $entity;
            }
        }
        return $total ? : $collection;
    }

    public function getIds() {
        $prKey = $this->getClassMetadata()->getSingleIdentifierFieldName();
        $result = $this->_em
            ->createQueryBuilder()
            ->select('entity.' . $prKey)
            ->from($this->_entityName, 'entity')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        $array = array();

        foreach ($result as $id) {
            $array[] = $id[$prKey];
        }

        return $array;
    }
}
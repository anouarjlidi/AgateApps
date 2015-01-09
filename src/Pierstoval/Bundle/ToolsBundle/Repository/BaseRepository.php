<?php

namespace Pierstoval\Bundle\ToolsBundle\Repository;
use Doctrine\ORM\EntityRepository as EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * BaseRepository
 * Gestionnaire de repositories de Corahn-Rin
 */
abstract class BaseRepository extends EntityRepository {

    protected function defaultFindBy(QueryBuilder $qb, array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {

        foreach ($criteria as $field => $value) {
            $qb->where('r.'.$field.' = :'.$field)
                ->setParameter($field, $value);
        }
        if (is_string($orderBy)) {
            $qb->orderBy($orderBy);
        } elseif (is_array($orderBy)) {
            foreach ($orderBy as $field => $order) {
                $qb->orderBy($field, $order);
            }
        }

        if (null !== $offset) { $qb->setFirstResult($offset); }
        if (null !== $limit) { $qb->setMaxResults($limit); }

        $datas = $qb->getQuery()->getResult();

        if ($sortCollection) {
            $datas = $this->sortCollection($datas);
        }

        return $datas;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false) {
        // Check
        if ($this->getClassMetadata()->hasField('deleted') && !isset($criteria['deleted'])) {
            $criteria['deleted'] = '0';
        }
        $datas = parent::findBy($criteria, $orderBy, $limit, $offset);
        if ($datas && $sortCollection === true) {
            $datas = $this->sortCollection($datas);
        }
        return $datas;
    }

    public function findAll($sortCollection = false) {
        return $this->findBy(array(), null, null, null, $sortCollection);
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
        $statement = $connection->prepare('SHOW TABLE STATUS LIKE "'.$table.'" ');
        $statement->execute();
        $datas = $statement->fetch();

        $max = (int) $datas['Auto_increment'];

        return $max;
    }

    public function sortCollection($collection, $by = '_primary'){
        $total = array();
        $current = current($collection);
        if ('_primary' === $by) {
            $by = $this->getClassMetadata()->getSingleIdentifierFieldName();
        }
        if (property_exists($current, $by)) {
            foreach ($collection as $entity) {
                $total[$entity->{'get'.ucfirst($by)}()] = $entity;
            }
        }
        return $total ?: $collection;
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
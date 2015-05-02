<?php

namespace Pierstoval\Bundle\ToolsBundle\Repository;

use Doctrine\ORM\EntityRepository as EntityRepository;
use Doctrine\ORM\Query;

/**
 * BaseRepository
 * Gestionnaire de repositories de Corahn-Rin
 */
class BaseRepository extends EntityRepository
{

    /**
     * @param string $sortCollection
     *
     * @return array
     */
    public function findAllRoot($sortCollection = null)
    {
        return $this->createQueryBuilder('object', $sortCollection)->getQuery()->getResult();
    }

    /**
     * @param string $sortCollection
     *
     * @return array
     */
    public function findAllArray($sortCollection = null)
    {
        return $this->createQueryBuilder('object', $sortCollection)->getQuery()->getArrayResult();
    }

    /**
     * {@inheritdoc}
     * @param boolean $sortCollection If set to "true", the final collection will have primary keys as array keys
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $sortCollection = false)
    {
        $datas = parent::findBy($criteria, $orderBy, $limit, $offset);
        if ($datas && true === $sortCollection) {
            $datas = $this->sortCollection($datas);
        }
        return $datas;
    }

    /**
     * {@inheritdoc}
     * @param boolean $sortCollection If set to "true", the final collection will have primary keys as array keys
     */
    public function findAll($sortCollection = false)
    {
        $datas = $this->findBy(array());

        if ($datas && true === $sortCollection) {
            $datas = $this->sortCollection($datas);
        }

        return $datas;
    }

    /**
     * Gets current AUTO_INCREMENT value from table
     * @return integer
     */
    public function getAutoIncrement()
    {
        $table = $this->getClassMetadata()->getTableName();

        $connection = $this->getEntityManager()->getConnection();
        $statement  = $connection->prepare('SHOW TABLE STATUS LIKE "'.$table.'" ');
        $statement->execute();
        $datas = $statement->fetch();

        $max = (int) $datas['Auto_increment'];

        return $max;
    }

    /**
     * Gets total number of elements in the table
     * @return integer
     */
    public function getNumberOfElements()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(a)')
           ->where('a.deleted = 0')
           ->from($this->getEntityName(), 'a');

        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }

    /**
     * Alias for BaseRepository::getAutoIncrement()
     * @see BaseRepository::getAutoIncrement()
     */
    public function getMax()
    {
        return $this->getAutoIncrement();
    }

    /**
     * Sorts a collection by a specific key, usually the primary key one,
     *  but you can specify any key.
     * For "cleanest" uses, you'd better use a primary or unique key.
     *
     * @param        $collection
     * @param string $by
     *
     * @return mixed
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function sortCollection($collection, $by = '_primary')
    {
        $total   = array();
        $current = current($collection);
        if ('_primary' === $by) {
            $by = $this->getClassMetadata()->getSingleIdentifierFieldName();
        }
        if (property_exists($current, $by)) {
            foreach ($collection as $entity) {
                $total[$entity->{'get'.ucfirst($by)}()] = $entity;
            }
        }
        return $total ? : $collection;
    }

    /**
     * Gets the list of all single identifiers (id) from table
     *
     * @return array
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function getIds()
    {
        $prKey  = $this->getClassMetadata()->getSingleIdentifierFieldName();
        $result = $this->_em
            ->createQueryBuilder()
            ->select('entity.'.$prKey)
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
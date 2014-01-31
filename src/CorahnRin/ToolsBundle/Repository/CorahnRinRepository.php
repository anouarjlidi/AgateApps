<?php

namespace CorahnRin\ToolsBundle\Repository;
use Doctrine\ORM\EntityRepository as EntityRepository;

/**
 * CorahnRinRepository
 * Gestionnaire de repositories de Corahn-Rin
 */
abstract class CorahnRinRepository extends EntityRepository {

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

    public function sortCollection($collection){
        $total = array();
        $current = current($collection);
        $primary = $this->getClassMetadata()->getSingleIdentifierFieldName();
        if (property_exists($current, $primary)) {
            foreach ($collection as $entity) {
                $total[$entity->{'get'.ucfirst($primary)}()] = $entity;
            }
        }
        return $total ?: $collection;
    }
}
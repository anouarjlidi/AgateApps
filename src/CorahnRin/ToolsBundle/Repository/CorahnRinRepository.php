<?php

namespace CorahnRin\ToolsBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * CorahnRinRepository
 * Gestionnaire de repositories de Corahn-Rin
 */
abstract class CorahnRinRepository extends EntityRepository {

    public function findAll($sortCollection = false) {
        $datas = parent::findAll();
        $total = array();
        if ($datas) {
            if ($sortCollection === false) {
                $total = $datas;
            } else {
                foreach ($datas as $entity) {
                    $total[$entity->getId()] = $entity;
                }
            }
        }
        return $total;
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
}
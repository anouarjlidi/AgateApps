<?php

namespace CorahnRin\ToolsBundle\Repository;
use Doctrine\ORM\EntityRepository;

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
}
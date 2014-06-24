<?php
namespace CorahnRin\ModelsBundle\Repository;

use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * DomainsRepository
 *
 */
class DomainsRepository extends CorahnRinRepository {

    public function findAllSortedByName(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null, $sortCollection = true) {
        $orderBy = array('name' => 'asc');
        $datas = $this->findBy($criteria, $orderBy, $limit, $offset, $sortCollection);
        foreach ($datas as $id => $element) {
            $datas[$id] = $element->getName();
        }
        return $datas;
    }
}
<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * AvantagesRepository
 *
 */
class AvantagesRepository extends CorahnRinRepository {

    function findAllDifferenciated() {
        $list = $this->findAll();
        $advantages = $disadvantages = array();
        foreach ($list as $id => $element) {
            if ($element->getIsDesv()) {
                $disadvantages[$id] = $element;
            } else {
                $advantages[$id] = $element;
            }
        }
        return array(
            'advantages' => $advantages,
            'disadvantages' => $disadvantages,
        );
    }

}
<?php
namespace CorahnRin\CharactersBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * TraitsRepository
 *
 */
class TraitsRepository extends CorahnRinRepository {

    function findAllDifferenciated() {
        $list = $this->findBy(array(), array('name'=>'asc'));
        $qualities = $defaults = array();
        foreach ($list as $id => $element) {
            if (!$element->getIsQuality()) {
                $defaults[$id] = $element;
            } else {
                $qualities[$id] = $element;
            }
        }
        return array(
            'qualities' => $qualities,
            'defaults' => $defaults,
        );
    }
}
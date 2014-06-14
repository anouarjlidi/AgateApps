<?php
namespace CorahnRin\ModelsBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * AvantagesRepository
 *
 */
class AvantagesRepository extends CorahnRinRepository {

    /**
     * @return array Un tableau de deux tableaux : "advantages" et "disadvantages"
     */
    function findAllDifferenciated() {
        $list = $this->findAll(true);
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
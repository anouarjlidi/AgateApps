<?php
namespace CorahnRin\ModelsBundle\Repository;

use Pierstoval\Bundle\ToolsBundle\Repository\BaseRepository;

/**
 * AvantagesRepository
 *
 */
class AvantagesRepository extends BaseRepository {

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
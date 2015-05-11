<?php
namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\Avantages;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

/**
 * AvantagesRepository
 *
 */
class AvantagesRepository extends BaseRepository {

    /**
     * @return array Un tableau de deux tableaux : "advantages" et "disadvantages"
     */
    function findAllDifferenciated() {
        /** @var Avantages[] $list */
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
<?php

namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\Avantages;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class AvantagesRepository extends BaseRepository
{
    /**
     * @return Avantages[][]
     */
    public function findAllDifferenciated()
    {
        /** @var Avantages[] $list */
        $list       = $this->findAll();
        $advantages = $disadvantages = [];

        foreach ($list as $element) {
            $id = $element->getId();
            if ($element->getIsDesv()) {
                $disadvantages[$id] = $element;
            } else {
                $advantages[$id] = $element;
            }
        }

        return [
            'advantages'    => $advantages,
            'disadvantages' => $disadvantages,
        ];
    }
}

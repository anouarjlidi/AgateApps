<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\Avantages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Orbitale\Component\DoctrineTools\EntityRepositoryHelperTrait;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AvantagesRepository extends ServiceEntityRepository
{
    use EntityRepositoryHelperTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Avantages::class);
    }

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
            if ($element->isDesv()) {
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

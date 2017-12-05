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

use CorahnRin\CorahnRinBundle\Entity\Traits;
use CorahnRin\CorahnRinBundle\Entity\Ways;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Orbitale\Component\DoctrineTools\EntityRepositoryHelperTrait;

class TraitsRepository extends ServiceEntityRepository
{
    use EntityRepositoryHelperTrait;

    /**
     * @return Traits[][]
     */
    public function findAllDifferenciated()
    {
        $list      = $this->findBy([], ['name' => 'asc'], null, null, true);
        $qualities = $flaws = [];
        foreach ($list as $id => $element) {
            if ($element instanceof Traits) {
                if (!$element->isQuality()) {
                    $flaws[$id] = $element;
                } else {
                    $qualities[$id] = $element;
                }
            }
        }

        return [
            'qualities' => $qualities,
            'flaws'     => $flaws,
        ];
    }

    /**
     * @param Traits[] $traits
     *
     * @return array
     */
    public function sortQualitiesFlaws($traits)
    {
        $list = [
            'qualities' => [],
            'flaws'     => [],
        ];

        foreach ($traits as $trait) {
            if ($trait->isQuality()) {
                $list['qualities'][$trait->getId()] = $trait;
            } else {
                $list['flaws'][$trait->getId()] = $trait;
            }
        }

        return $list;
    }

    /**
     * Récupère les données à partir des voies.
     * ATTENTION :
     * Le tableau $ways DOIT être structuré de cette façon :
     * (key) wayid => (value) way score.
     *
     * @param Ways[] $ways
     *
     * @throws \Exception
     *
     * @return array
     */
    public function findAllDependingOnWays(array $ways)
    {
        $qb = $this->_em
            ->createQueryBuilder()
            ->select('t')
            ->from($this->_entityName, 't')
            ->leftJoin('t.way', 'w')
            ->addSelect('w')
        ;
        foreach ($ways as $id => $value) {
            if (!is_numeric($id) || !is_numeric($value)) {
                throw new \Exception('Error in ways values. Must be equivalent to this : array( [WAY_ID] => [WAY_VALUE] )');
            }
            if ($id >= 4 || $id <= 2) {
                $qb->orWhere('w.id = :way'.$id.' AND t.major = :way'.$id.'major')
                   ->setParameter(':way'.$id, $id)
                   ->setParameter(':way'.$id.'major', $value >= 4)
                ;
            }
        }

        $qb->orderBy('t.name', 'asc');

        $list = $qb->getQuery()->getResult();

        return $this->sortQualitiesFlaws($list);
    }
}

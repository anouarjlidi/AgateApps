<?php
namespace Esteren\PagesBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;
use Esteren\PagesBundle\Entity\Menus;

/**
 * MenusRepository
 *
 */
class MenusRepository extends CorahnRinRepository {

    /**
     * @return Menus[]
     */
    public function findForAdmin() {
        $qb = $this->_em
            ->createQueryBuilder()
            ->select('menus')
            ->from($this->_entityName, 'menus')
            ->leftJoin('menus.parent', 'parent0')
            ->addSelect('parent0');

        for ($i = 0; $i < 10; $i++) {
            $qb->leftJoin('parent'.$i.'.parent', 'parent'.($i + 1))
               ->addSelect('parent'.($i + 1));
        }

        $qb->addOrderBy('menus.position', 'asc');
        $qb->addOrderBy('menus.parent', 'asc');
        $qb->addOrderBy('menus.name', 'asc');

        $list = $qb->getQuery()->getResult();

        return $this->orderTree(0, $list);
    }

    /**
     * @param integer|string|null $sourceElement
     * @return Menus[]
     */
    public function findTree($sourceElement = null) {

        $sortBy = array(
            'position' => 'asc',
            'parent' => 'asc',
            'name' => 'asc',
        );
        $list = $this->findBy(array(), $sortBy, null, null, false);
        //$this->findBy($sortBy, $orderBy, $limit, $offset, $sortCollection)

        $list = $this->orderTree(0, $list);

        $final = array();
        foreach ($list as $k => $element) {
            if (
                !$sourceElement
                ||
                ($sourceElement && is_numeric($sourceElement) && $element->getId() == $sourceElement)
                ||
                ($sourceElement && is_string($sourceElement) && $element->getName() == $sourceElement)
            ) {
                $final = array($k=>$element);
            }
        }

        return $final;
    }

    /**
     * Trie récursivement les liens de menu
     * @param int $level
     * @param Menus[] $list
     * @return Menus[]
     */
    public function orderTree($level,$list) {
        $elements = array();
        foreach ($list as $element) {
            $parent = $element->getParent() ? $element->getParent()->getId() : 0;
            if ($parent == $level) {
                $element->setChildren($this->orderTree($element->getId(), $list));
                $elements[$element->getId()] = $element;
            }
        }
        return $elements;
    }

}
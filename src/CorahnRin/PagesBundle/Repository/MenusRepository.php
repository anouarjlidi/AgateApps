<?php
namespace CorahnRin\PagesBundle\Repository;
use Doctrine\ORM\EntityRepository;
use CorahnRin\ToolsBundle\Repository\CorahnRinRepository as CorahnRinRepository;

/**
 * MenusRepository
 *
 */
class MenusRepository extends CorahnRinRepository {

    public function findForAdmin($sortCollection = false) {
        $sortBy = array(
            'parent' => 'asc',
            'position' => 'asc',
        );
        return $this->findBy(array(), $sortBy, null, null, $sortCollection);
    }

    public function findTree($sourceElement = null) {

        $sortBy = array(
            'position' => 'asc',
            'parent' => 'asc',
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
     * @param array $list
     * @return array
     */
    private function orderTree($level,$list) {
        $elements = array();
        foreach ($list as $id => $element) {
            $parent = $element->getParent() ? $element->getParent()->getId() : 0;
            if ($parent == $level) {
                $element->setChildren($this->orderTree($element->getId(), $list));
                $elements[$element->getId()] = $element;
            }
        }
        return $elements;
    }

}
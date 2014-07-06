<?php

namespace Esteren\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Menus
 *
 * @ORM\Table(name="menus",uniqueConstraints={@ORM\UniqueConstraint(name="menuParentUnique", columns={"name", "parent_id"})})
 * @ORM\Entity(repositoryClass="Esteren\PagesBundle\Repository\MenusRepository")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 */
class Menus {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=80)
     */
    protected $name;

    /**
     * @var Menus
     *
     * @ORM\ManyToOne(targetEntity="Menus")
     */
    protected $parent;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="smallint", options={"default":0})
     */
    protected $position;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    protected $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    protected $route;

    /**
     * @var \Datetime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    protected $children = array();

    /**
     * @param Menus $child
     * @return $this
     */
    public function addChild($child) {
        $this->children[$child->getId()] = $child;
        return $this;
    }

    /**
     * @param Menus[] $children
     * @return $this
     */
    public function setChildren($children) {
        $this->children = $children;
        return $this;
    }

    /**
     * @return Menus[]
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @param Menus $child
     * @return $this
     */
    public function removeChild($child) {
        if (is_numeric($child)) {
            unset($this->children[$child]);
        } elseif (is_object($child)) {
            unset($this->children[$child->getId()]);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function __toString() {
        $str = $this->id . ' ';
        for ($i = 10; $i > 0; $i--) {
            if ($this->getParentByLevel($i)) {
                $str .= strip_tags($this->getParentByLevel($i)->getName()).' '.html_entity_decode('&raquo;').' ';
            }
        }
        return $str.strip_tags($this->name);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Menus
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Menus
     */
    public function setPosition($position) {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return Menus
     */
    public function setRoute($route) {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Menus
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Menus
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Set parent
     *
     * @param Menus $parent
     * @return Menus
     */
    public function setParent(Menus $parent = null) {
        $this->parent = $parent;;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Menus
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return Menus
     */
    public function setRoles($roles) {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * Retourne le parent à un certain niveau d'héritage
     * @param int $level
     * @return Menus|null
     */
    public function getParentByLevel($level = 0) {
        $actualParent = $this->parent;
        if ($actualParent) {
            while ($level > 0) {
                $actualParent = $actualParent->getParent();
                $level--;
                if (!$actualParent && $level > 0) {
                    $level = 0;
                }
            }
        }
        return $actualParent;
    }
}

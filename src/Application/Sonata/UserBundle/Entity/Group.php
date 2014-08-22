<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

/**
 * @Table(name="groups")
 * @Entity(repositoryClass="Application\Sonata\UserBundle\Repository\GroupRepository")
 */
class Group extends BaseGroup {

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * Get id
     * @return integer $id
     */
    public function getId() {
        return $this->id;
    }
}
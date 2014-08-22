<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Application\Sonata\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser {

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
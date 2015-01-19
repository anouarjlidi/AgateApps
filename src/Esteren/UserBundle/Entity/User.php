<?php

namespace Esteren\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * @ORM\Entity()
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

    /**
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
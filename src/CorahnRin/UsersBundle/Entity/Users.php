<?php

namespace CorahnRin\UsersBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class Users extends BaseUser {
	
	/**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="CorahnRin\CharactersBundle\Entity\Characters", mappedBy="user")
	 */
	protected $characters;

}
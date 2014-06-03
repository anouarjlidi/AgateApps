<?php

namespace CorahnRin\UsersBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class Users extends BaseUser {

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
     * @var Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="CorahnRin\CharactersBundle\Entity\Characters", mappedBy="user")
	 */
	protected $characters;

    /**
     * Constructor
     */
    public function __construct()
    {
		parent::__construct();
        $this->characters = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add characters
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $characters
     * @return Users
     */
    public function addCharacter(\CorahnRin\CharactersBundle\Entity\Characters $characters)
    {
        $this->characters[] = $characters;
    
        return $this;
    }

    /**
     * Remove characters
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $characters
     */
    public function removeCharacter(\CorahnRin\CharactersBundle\Entity\Characters $characters)
    {
        $this->characters->removeElement($characters);
    }

    /**
     * Get characters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}

<?php

namespace CorahnRin\UsersBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use CorahnRin\ModelsBundle\Entity\Characters;

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
     * @var Characters[]
     * @ORM\OneToMany(targetEntity="CorahnRin\ModelsBundle\Entity\Characters", mappedBy="user")
	 */
	protected $characters;

    /**
     * @var Groups[]
     * @ORM\ManyToMany(targetEntity="CorahnRin\UsersBundle\Entity\Groups")
     */
    protected $groups;

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
     * @param \CorahnRin\ModelsBundle\Entity\Characters $characters
     * @return Users
     */
    public function addCharacter(\CorahnRin\ModelsBundle\Entity\Characters $characters)
    {
        $this->characters[] = $characters;

        return $this;
    }

    /**
     * Remove characters
     *
     * @param \CorahnRin\ModelsBundle\Entity\Characters $characters
     */
    public function removeCharacter(\CorahnRin\ModelsBundle\Entity\Characters $characters)
    {
        $this->characters->removeElement($characters);
    }

    /**
     * Get characters
     *
     * @return Characters[]
     */
    public function getCharacters()
    {
        return $this->characters;
    }

}

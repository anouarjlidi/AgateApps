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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    private $Games;

    /**
     * Constructor
     */
    public function __construct()
    {   
        parent::__construct();
        $this->Games = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add Games
     *
     * @param \CorahnRin\CharactersBundle\Entity\Games $games
     * @return Users
     */
    public function addGame(\CorahnRin\CharactersBundle\Entity\Games $games)
    {
        $this->Games[] = $games;
    
        return $this;
    }

    /**
     * Remove Games
     *
     * @param \CorahnRin\CharactersBundle\Entity\Games $games
     */
    public function removeGame(\CorahnRin\CharactersBundle\Entity\Games $games)
    {
        $this->Games->removeElement($games);
    }

    /**
     * Get Games
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGames()
    {
        return $this->Games;
    }

}
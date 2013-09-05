<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharModifications
 *
 * @ORM\Table(name="char_modifications")
 * @ORM\Entity
 */
class CharModifications
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content_before", type="text", nullable=false)
     */
    private $contentBefore;

    /**
     * @var string
     *
     * @ORM\Column(name="content_after", type="text", nullable=false)
     */
    private $contentAfter;

    /**
     * @var integer
     *
     * @ORM\Column(name="date_created", type="integer", nullable=false)
     */
    private $dateCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="date_updated", type="integer", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var \Characters
     *
     * @ORM\ManyToOne(targetEntity="Characters")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     * })
     */
    private $Characters;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\UsersBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_users", referencedColumnName="id")
     * })
     */
    private $Users;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contentBefore
     *
     * @param string $contentBefore
     * @return CharModifications
     */
    public function setContentBefore($contentBefore)
    {
        $this->contentBefore = $contentBefore;
    
        return $this;
    }

    /**
     * Get contentBefore
     *
     * @return string 
     */
    public function getContentBefore()
    {
        return $this->contentBefore;
    }

    /**
     * Set contentAfter
     *
     * @param string $contentAfter
     * @return CharModifications
     */
    public function setContentAfter($contentAfter)
    {
        $this->contentAfter = $contentAfter;
    
        return $this;
    }

    /**
     * Get contentAfter
     *
     * @return string 
     */
    public function getContentAfter()
    {
        return $this->contentAfter;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return CharModifications
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return integer 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param integer $dateUpdated
     * @return CharModifications
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    
        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return integer 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set Characters
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $characters
     * @return CharModifications
     */
    public function setCharacters(\CorahnRin\CharactersBundle\Entity\Characters $characters = null)
    {
        $this->Characters = $characters;
    
        return $this;
    }

    /**
     * Get Characters
     *
     * @return \CorahnRin\CharactersBundle\Entity\Characters 
     */
    public function getCharacters()
    {
        return $this->Characters;
    }

    /**
     * Set Users
     *
     * @param \CorahnRin\CharactersBundle\Entity\Users $users
     * @return CharModifications
     */
    public function setUsers(\CorahnRin\CharactersBundle\Entity\Users $users = null)
    {
        $this->Users = $users;
    
        return $this;
    }

    /**
     * Get Users
     *
     * @return \CorahnRin\CharactersBundle\Entity\Users 
     */
    public function getUsers()
    {
        return $this->Users;
    }
}
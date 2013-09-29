<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Miracles
 *
 * @ORM\Entity
 */
class Miracles
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=70, nullable=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isMajor;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Characters", inversedBy="Miracles")
     * @ORM\JoinTable(name="char_miracles",
     *   joinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   }
     * )
     */
    private $Characters;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Characters = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set name
     *
     * @param string $name
     * @return Miracles
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isMajor
     *
     * @param boolean $isMajor
     * @return Miracles
     */
    public function setIsMajor($isMajor)
    {
        $this->isMajor = $isMajor;
    
        return $this;
    }

    /**
     * Get isMajor
     *
     * @return boolean 
     */
    public function getIsMajor()
    {
        return $this->isMajor;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return Miracles
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
     * @return Miracles
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
     * Add Characters
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $characters
     * @return Miracles
     */
    public function addCharacter(\CorahnRin\CharactersBundle\Entity\Characters $characters)
    {
        $this->Characters[] = $characters;
    
        return $this;
    }

    /**
     * Remove Characters
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $characters
     */
    public function removeCharacter(\CorahnRin\CharactersBundle\Entity\Characters $characters)
    {
        $this->Characters->removeElement($characters);
    }

    /**
     * Get Characters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCharacters()
    {
        return $this->Characters;
    }
}
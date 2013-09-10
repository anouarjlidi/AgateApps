<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domains
 *
 * @ORM\Table(name="domains")
 * @ORM\Entity
 */
class Domains
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=70, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Characters", mappedBy="Domains")
     */
    private $Characters;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Disciplines", mappedBy="Domains")
     */
    private $Disciplines;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SocialClass", mappedBy="Domains")
     */
    private $SocialClass;

    /**
     * @var \Ways
     *
     * @ORM\ManyToOne(targetEntity="Ways")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ways", referencedColumnName="id")
     * })
     */
    private $Ways;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Characters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Disciplines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->SocialClass = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Domains
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
     * Set description
     *
     * @param string $description
     * @return Domains
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return Domains
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
     * @return Domains
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
     * @return Domains
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

    /**
     * Add Disciplines
     *
     * @param \CorahnRin\CharactersBundle\Entity\Disciplines $disciplines
     * @return Domains
     */
    public function addDiscipline(\CorahnRin\CharactersBundle\Entity\Disciplines $disciplines)
    {
        $this->Disciplines[] = $disciplines;
    
        return $this;
    }

    /**
     * Remove Disciplines
     *
     * @param \CorahnRin\CharactersBundle\Entity\Disciplines $disciplines
     */
    public function removeDiscipline(\CorahnRin\CharactersBundle\Entity\Disciplines $disciplines)
    {
        $this->Disciplines->removeElement($disciplines);
    }

    /**
     * Get Disciplines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDisciplines()
    {
        return $this->Disciplines;
    }

    /**
     * Add SocialClass
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClass $socialClass
     * @return Domains
     */
    public function addSocialClas(\CorahnRin\CharactersBundle\Entity\SocialClass $socialClass)
    {
        $this->SocialClass[] = $socialClass;
    
        return $this;
    }

    /**
     * Remove SocialClass
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClass $socialClass
     */
    public function removeSocialClas(\CorahnRin\CharactersBundle\Entity\SocialClass $socialClass)
    {
        $this->SocialClass->removeElement($socialClass);
    }

    /**
     * Get SocialClass
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSocialClass()
    {
        return $this->SocialClass;
    }

    /**
     * Set Ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ways $ways
     * @return Domains
     */
    public function setWays(\CorahnRin\CharactersBundle\Entity\Ways $ways = null)
    {
        $this->Ways = $ways;
    
        return $this;
    }

    /**
     * Get Ways
     *
     * @return \CorahnRin\CharactersBundle\Entity\Ways 
     */
    public function getWays()
    {
        return $this->Ways;
    }
}
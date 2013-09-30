<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domains
 *
 * @ORM\Entity
 */
class Domains
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
     * @ORM\Column(type="string", length=70, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

    /**
     * @var \Datetime
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \Datetime

     * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;

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
     *   @ORM\JoinColumn(referencedColumnName="id")
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
     * Set created
     *
     * @param \DateTime $created
     * @return Domains
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Domains
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
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
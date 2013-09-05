<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traits
 *
 * @ORM\Table(name="traits")
 * @ORM\Entity
 */
class Traits
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_female", type="string", length=50, nullable=false)
     */
    private $nameFemale;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_quality", type="boolean", nullable=false)
     */
    private $isQuality;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_major", type="boolean", nullable=false)
     */
    private $isMajor;

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
     * @var \Ways
     *
     * @ORM\ManyToOne(targetEntity="Ways")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ways", referencedColumnName="id")
     * })
     */
    private $Ways;



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
     * @return Traits
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
     * Set nameFemale
     *
     * @param string $nameFemale
     * @return Traits
     */
    public function setNameFemale($nameFemale)
    {
        $this->nameFemale = $nameFemale;
    
        return $this;
    }

    /**
     * Get nameFemale
     *
     * @return string 
     */
    public function getNameFemale()
    {
        return $this->nameFemale;
    }

    /**
     * Set isQuality
     *
     * @param boolean $isQuality
     * @return Traits
     */
    public function setIsQuality($isQuality)
    {
        $this->isQuality = $isQuality;
    
        return $this;
    }

    /**
     * Get isQuality
     *
     * @return boolean 
     */
    public function getIsQuality()
    {
        return $this->isQuality;
    }

    /**
     * Set isMajor
     *
     * @param boolean $isMajor
     * @return Traits
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
     * @return Traits
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
     * @return Traits
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
     * Set Ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ways $ways
     * @return Traits
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
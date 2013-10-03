<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traits
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\TraitsRepository")
 */
class Traits
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
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $nameFemale;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isQuality;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isMajor;

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
     * @var \Ways
     *
     * @ORM\ManyToOne(targetEntity="Ways")
     */
    private $way;




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
     * Set created
     *
     * @param \DateTime $created
     * @return Traits
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
     * @return Traits
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
     * Set way
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ways $way
     * @return Traits
     */
    public function setWay(\CorahnRin\CharactersBundle\Entity\Ways $way = null)
    {
        $this->way = $way;
    
        return $this;
    }

    /**
     * Get way
     *
     * @return \CorahnRin\CharactersBundle\Entity\Ways 
     */
    public function getWay()
    {
        return $this->way;
    }
}
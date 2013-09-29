<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avdesv
 *
 * @ORM\Entity
 */
class Avdesv
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
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $nameFemale;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $xp;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $canBeDoubled;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $bonusdisc;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isDesv;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isCombatArt;

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
     * @return Avdesv
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
     * @return Avdesv
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
     * Set xp
     *
     * @param integer $xp
     * @return Avdesv
     */
    public function setXp($xp)
    {
        $this->xp = $xp;
    
        return $this;
    }

    /**
     * Get xp
     *
     * @return integer 
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Avdesv
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
     * Set canBeDoubled
     *
     * @param boolean $canBeDoubled
     * @return Avdesv
     */
    public function setCanBeDoubled($canBeDoubled)
    {
        $this->canBeDoubled = $canBeDoubled;
    
        return $this;
    }

    /**
     * Get canBeDoubled
     *
     * @return boolean 
     */
    public function getCanBeDoubled()
    {
        return $this->canBeDoubled;
    }

    /**
     * Set bonusdisc
     *
     * @param string $bonusdisc
     * @return Avdesv
     */
    public function setBonusdisc($bonusdisc)
    {
        $this->bonusdisc = $bonusdisc;
    
        return $this;
    }

    /**
     * Get bonusdisc
     *
     * @return string 
     */
    public function getBonusdisc()
    {
        return $this->bonusdisc;
    }

    /**
     * Set isDesv
     *
     * @param boolean $isDesv
     * @return Avdesv
     */
    public function setIsDesv($isDesv)
    {
        $this->isDesv = $isDesv;
    
        return $this;
    }

    /**
     * Get isDesv
     *
     * @return boolean 
     */
    public function getIsDesv()
    {
        return $this->isDesv;
    }

    /**
     * Set isCombatArt
     *
     * @param boolean $isCombatArt
     * @return Avdesv
     */
    public function setIsCombatArt($isCombatArt)
    {
        $this->isCombatArt = $isCombatArt;
    
        return $this;
    }

    /**
     * Get isCombatArt
     *
     * @return boolean 
     */
    public function getIsCombatArt()
    {
        return $this->isCombatArt;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return Avdesv
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
     * @return Avdesv
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
}
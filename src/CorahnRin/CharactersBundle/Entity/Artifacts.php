<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artifacts
 *
 * @ORM\Table(name="artifacts")
 * @ORM\Entity
 */
class Artifacts
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
     * @ORM\Column(name="name", type="string", length=70, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="consumption_value", type="integer", nullable=false)
     */
    private $consumptionValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="consuption_interval", type="integer", nullable=false)
     */
    private $consuptionInterval;

    /**
     * @var integer
     *
     * @ORM\Column(name="tank", type="integer", nullable=false)
     */
    private $tank;

    /**
     * @var integer
     *
     * @ORM\Column(name="resistance", type="integer", nullable=false)
     */
    private $resistance;

    /**
     * @var string
     *
     * @ORM\Column(name="vulnerability", type="string", length=70, nullable=false)
     */
    private $vulnerability;

    /**
     * @var string
     *
     * @ORM\Column(name="handling", type="string", length=20, nullable=false)
     */
    private $handling;

    /**
     * @var integer
     *
     * @ORM\Column(name="damage", type="integer", nullable=false)
     */
    private $damage;

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
     * @ORM\ManyToMany(targetEntity="Characters", mappedBy="Artifacts")
     */
    private $Characters;

    /**
     * @var \Flux
     *
     * @ORM\ManyToOne(targetEntity="Flux")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_flux", referencedColumnName="id")
     * })
     */
    private $Flux;

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
     * @return Artifacts
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
     * Set price
     *
     * @param integer $price
     * @return Artifacts
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set consumptionValue
     *
     * @param integer $consumptionValue
     * @return Artifacts
     */
    public function setConsumptionValue($consumptionValue)
    {
        $this->consumptionValue = $consumptionValue;
    
        return $this;
    }

    /**
     * Get consumptionValue
     *
     * @return integer 
     */
    public function getConsumptionValue()
    {
        return $this->consumptionValue;
    }

    /**
     * Set consuptionInterval
     *
     * @param integer $consuptionInterval
     * @return Artifacts
     */
    public function setConsuptionInterval($consuptionInterval)
    {
        $this->consuptionInterval = $consuptionInterval;
    
        return $this;
    }

    /**
     * Get consuptionInterval
     *
     * @return integer 
     */
    public function getConsuptionInterval()
    {
        return $this->consuptionInterval;
    }

    /**
     * Set tank
     *
     * @param integer $tank
     * @return Artifacts
     */
    public function setTank($tank)
    {
        $this->tank = $tank;
    
        return $this;
    }

    /**
     * Get tank
     *
     * @return integer 
     */
    public function getTank()
    {
        return $this->tank;
    }

    /**
     * Set resistance
     *
     * @param integer $resistance
     * @return Artifacts
     */
    public function setResistance($resistance)
    {
        $this->resistance = $resistance;
    
        return $this;
    }

    /**
     * Get resistance
     *
     * @return integer 
     */
    public function getResistance()
    {
        return $this->resistance;
    }

    /**
     * Set vulnerability
     *
     * @param string $vulnerability
     * @return Artifacts
     */
    public function setVulnerability($vulnerability)
    {
        $this->vulnerability = $vulnerability;
    
        return $this;
    }

    /**
     * Get vulnerability
     *
     * @return string 
     */
    public function getVulnerability()
    {
        return $this->vulnerability;
    }

    /**
     * Set handling
     *
     * @param string $handling
     * @return Artifacts
     */
    public function setHandling($handling)
    {
        $this->handling = $handling;
    
        return $this;
    }

    /**
     * Get handling
     *
     * @return string 
     */
    public function getHandling()
    {
        return $this->handling;
    }

    /**
     * Set damage
     *
     * @param integer $damage
     * @return Artifacts
     */
    public function setDamage($damage)
    {
        $this->damage = $damage;
    
        return $this;
    }

    /**
     * Get damage
     *
     * @return integer 
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return Artifacts
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
     * @return Artifacts
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
     * @return Artifacts
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
     * Set Flux
     *
     * @param \CorahnRin\CharactersBundle\Entity\Flux $flux
     * @return Artifacts
     */
    public function setFlux(\CorahnRin\CharactersBundle\Entity\Flux $flux = null)
    {
        $this->Flux = $flux;
    
        return $this;
    }

    /**
     * Get Flux
     *
     * @return \CorahnRin\CharactersBundle\Entity\Flux 
     */
    public function getFlux()
    {
        return $this->Flux;
    }
}
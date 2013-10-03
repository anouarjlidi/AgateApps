<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artifacts
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\ArtifactsRepository")
 */
class Artifacts
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
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $price;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    private $consumption;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    private $consumptionInterval;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $tank;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $resistance;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=70, nullable=false)
     */
    private $vulnerability;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $handling;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $damage;

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
     * @var \Flux
     *
     * @ORM\ManyToOne(targetEntity="Flux")
     */
    private $flux;


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
     * Set consumption
     *
     * @param integer $consumption
     * @return Artifacts
     */
    public function setConsumption($consumption)
    {
        $this->consumption = $consumption;
    
        return $this;
    }

    /**
     * Get consumption
     *
     * @return integer 
     */
    public function getConsumption()
    {
        return $this->consumption;
    }

    /**
     * Set consumptionInterval
     *
     * @param integer $consumptionInterval
     * @return Artifacts
     */
    public function setConsumptionInterval($consumptionInterval)
    {
        $this->consumptionInterval = $consumptionInterval;
    
        return $this;
    }

    /**
     * Get consumptionInterval
     *
     * @return integer 
     */
    public function getConsumptionInterval()
    {
        return $this->consumptionInterval;
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
     * Set created
     *
     * @param \DateTime $created
     * @return Artifacts
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
     * @return Artifacts
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
     * Set flux
     *
     * @param \CorahnRin\CharactersBundle\Entity\Flux $flux
     * @return Artifacts
     */
    public function setFlux(\CorahnRin\CharactersBundle\Entity\Flux $flux = null)
    {
        $this->flux = $flux;
    
        return $this;
    }

    /**
     * Get flux
     *
     * @return \CorahnRin\CharactersBundle\Entity\Flux 
     */
    public function getFlux()
    {
        return $this->flux;
    }
}
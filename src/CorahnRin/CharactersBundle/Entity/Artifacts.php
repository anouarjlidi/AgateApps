<?php

namespace CorahnRin\CharactersBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Artifacts
 *
 * @ORM\Table(name="artifacts")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=70, nullable=false, unique=true)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $price;

    /**
     * @var integer
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $consumption;

    /**
     * @var integer
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $consumptionInterval;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $tank;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $resistance;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $vulnerability;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $handling;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $damage;

    /**
     * @var \Datetime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime

     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var Flux
     *
     * @ORM\ManyToOne(targetEntity="Flux")
     * @Assert\NotNull()
     * @ORM\JoinColumn(nullable=false)
     */
    protected $flux;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

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
     * @param Flux $flux
     * @return Artifacts
     */
    public function setFlux(Flux $flux = null)
    {
        $this->flux = $flux;

        return $this;
    }

    /**
     * Get flux
     *
     * @return Flux
     */
    public function getFlux()
    {
        return $this->flux;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Artifacts
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
}

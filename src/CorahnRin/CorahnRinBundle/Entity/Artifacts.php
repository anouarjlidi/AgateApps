<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Artifacts.
 *
 * @ORM\Table(name="artifacts")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 */
class Artifacts
{
    /**
     * @var int
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
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $price;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $consumption;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $consumptionInterval;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $tank;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
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
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $damage;

    /**
     * @var Flux
     *
     * @ORM\ManyToOne(targetEntity="Flux")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $flux;

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
     * @var bool
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Artifacts
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return Artifacts
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set consumption.
     *
     * @param int $consumption
     *
     * @return Artifacts
     */
    public function setConsumption($consumption)
    {
        $this->consumption = $consumption;

        return $this;
    }

    /**
     * Get consumption.
     *
     * @return int
     */
    public function getConsumption()
    {
        return $this->consumption;
    }

    /**
     * Set consumptionInterval.
     *
     * @param int $consumptionInterval
     *
     * @return Artifacts
     */
    public function setConsumptionInterval($consumptionInterval)
    {
        $this->consumptionInterval = $consumptionInterval;

        return $this;
    }

    /**
     * Get consumptionInterval.
     *
     * @return int
     */
    public function getConsumptionInterval()
    {
        return $this->consumptionInterval;
    }

    /**
     * Set tank.
     *
     * @param int $tank
     *
     * @return Artifacts
     */
    public function setTank($tank)
    {
        $this->tank = $tank;

        return $this;
    }

    /**
     * Get tank.
     *
     * @return int
     */
    public function getTank()
    {
        return $this->tank;
    }

    /**
     * Set resistance.
     *
     * @param int $resistance
     *
     * @return Artifacts
     */
    public function setResistance($resistance)
    {
        $this->resistance = $resistance;

        return $this;
    }

    /**
     * Get resistance.
     *
     * @return int
     */
    public function getResistance()
    {
        return $this->resistance;
    }

    /**
     * Set vulnerability.
     *
     * @param string $vulnerability
     *
     * @return Artifacts
     */
    public function setVulnerability($vulnerability)
    {
        $this->vulnerability = $vulnerability;

        return $this;
    }

    /**
     * Get vulnerability.
     *
     * @return string
     */
    public function getVulnerability()
    {
        return $this->vulnerability;
    }

    /**
     * Set handling.
     *
     * @param string $handling
     *
     * @return Artifacts
     */
    public function setHandling($handling)
    {
        $this->handling = $handling;

        return $this;
    }

    /**
     * Get handling.
     *
     * @return string
     */
    public function getHandling()
    {
        return $this->handling;
    }

    /**
     * Set damage.
     *
     * @param int $damage
     *
     * @return Artifacts
     */
    public function setDamage($damage)
    {
        $this->damage = $damage;

        return $this;
    }

    /**
     * Get damage.
     *
     * @return int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Artifacts
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Artifacts
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set flux.
     *
     * @param Flux $flux
     *
     * @return Artifacts
     */
    public function setFlux(Flux $flux = null)
    {
        $this->flux = $flux;

        return $this;
    }

    /**
     * Get flux.
     *
     * @return Flux
     */
    public function getFlux()
    {
        return $this->flux;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Artifacts
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return Artifacts
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}

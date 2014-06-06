<?php

namespace CorahnRin\CharactersBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Armors
 *
 * @ORM\Table(name="armors")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\ArmorsRepository")
 */
class Armors
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
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     * @Assert\GreaterThan(value=0)
     * @Assert\NotNull()
     */
    protected $protection;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     * @Assert\GreaterThan(value=0)
     * @Assert\NotNull()
     */
    protected $price;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     * @Assert\Choice(choices={"CO","FR","RA","EX"})
     */
    protected $availability;

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
     * @return Armors
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
     * @return Armors
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
     * Set protection
     *
     * @param integer $protection
     * @return Armors
     */
    public function setProtection($protection)
    {
        $this->protection = $protection;

        return $this;
    }

    /**
     * Get protection
     *
     * @return integer
     */
    public function getProtection()
    {
        return $this->protection;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Armors
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
     * Set availability
     *
     * @param string $availability
     * @return Armors
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return string
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Armors
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
     * @return Armors
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

}

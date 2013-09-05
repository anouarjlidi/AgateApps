<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Desordres
 *
 * @ORM\Table(name="desordres")
 * @ORM\Entity
 */
class Desordres
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
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

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
     * @ORM\ManyToMany(targetEntity="Ways", inversedBy="Desordres")
     * @ORM\JoinTable(name="disorder_ways",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_desordres", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ways", referencedColumnName="id")
     *   }
     * )
     */
    private $Ways;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Ways = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Desordres
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
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return Desordres
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
     * @return Desordres
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
     * Add Ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ways $ways
     * @return Desordres
     */
    public function addWay(\CorahnRin\CharactersBundle\Entity\Ways $ways)
    {
        $this->Ways[] = $ways;
    
        return $this;
    }

    /**
     * Remove Ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ways $ways
     */
    public function removeWay(\CorahnRin\CharactersBundle\Entity\Ways $ways)
    {
        $this->Ways->removeElement($ways);
    }

    /**
     * Get Ways
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWays()
    {
        return $this->Ways;
    }
}
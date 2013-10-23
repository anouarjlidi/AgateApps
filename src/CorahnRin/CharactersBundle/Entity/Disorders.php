<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Disorders
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\DisordersRepository")
 */
class Disorders
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
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     */
    private $name;

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
     * @ORM\OneToMany(targetEntity="DisordersWays", mappedBy="disorder")
     */
    private $ways;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ways = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Disorders
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
     * Set created
     *
     * @param \DateTime $created
     * @return Disorders
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
     * @return Disorders
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
     * Add ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharWays $ways
     * @return Disorders
     */
    public function addWay(\CorahnRin\CharactersBundle\Entity\CharWays $ways)
    {
        $this->ways[] = $ways;
    
        return $this;
    }

    /**
     * Remove ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharWays $ways
     */
    public function removeWay(\CorahnRin\CharactersBundle\Entity\CharWays $ways)
    {
        $this->ways->removeElement($ways);
    }

    /**
     * Get ways
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWays()
    {
        return $this->ways;
    }
}
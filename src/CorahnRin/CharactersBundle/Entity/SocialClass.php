<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocialClass
 *
 * @ORM\Table(name="social_class")
 * @ORM\Entity
 */
class SocialClass
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
     * @ORM\Column(name="name", type="string", length=25, nullable=false)
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
     * @ORM\ManyToMany(targetEntity="Domains", inversedBy="SocialClass")
     * @ORM\JoinTable(name="social_class_domains",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_social_class", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_domains", referencedColumnName="id")
     *   }
     * )
     */
    private $Domains;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Domains = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return SocialClass
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
     * @return SocialClass
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
     * @return SocialClass
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
     * Add Domains
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domains
     * @return SocialClass
     */
    public function addDomain(\CorahnRin\CharactersBundle\Entity\Domains $domains)
    {
        $this->Domains[] = $domains;
    
        return $this;
    }

    /**
     * Remove Domains
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domains
     */
    public function removeDomain(\CorahnRin\CharactersBundle\Entity\Domains $domains)
    {
        $this->Domains->removeElement($domains);
    }

    /**
     * Get Domains
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDomains()
    {
        return $this->Domains;
    }
}
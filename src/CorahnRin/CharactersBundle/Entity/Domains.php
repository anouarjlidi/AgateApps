<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domains
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\DomainsRepository")
 */
class Domains
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
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $description;

    /**
     * @var \Datetime
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime

     * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var \Ways
     *
     * @ORM\ManyToOne(targetEntity="Ways")
     */
    protected $way;

    /**
     * @var \SocialClass
     *
     * @ORM\ManyToMany(targetEntity="SocialClass", mappedBy="domains")
     */
    protected $socialClasses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->socialClasses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Domains
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
     * @return Domains
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
     * Set created
     *
     * @param \DateTime $created
     * @return Domains
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
     * @return Domains
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
     * @return Domains
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

    /**
     * Add socialClasses
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClass $socialClasses
     * @return Domains
     */
    public function addSocialClasse(\CorahnRin\CharactersBundle\Entity\SocialClass $socialClasses)
    {
        $this->socialClasses[] = $socialClasses;
    
        return $this;
    }

    /**
     * Remove socialClasses
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClass $socialClasses
     */
    public function removeSocialClasse(\CorahnRin\CharactersBundle\Entity\SocialClass $socialClasses)
    {
        $this->socialClasses->removeElement($socialClasses);
    }

    /**
     * Get socialClasses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSocialClasses()
    {
        return $this->socialClasses;
    }

    /**
     * Add socialClasses
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClass $socialClasses
     * @return Domains
     */
    public function addSocialClass(\CorahnRin\CharactersBundle\Entity\SocialClass $socialClasses)
    {
        $this->socialClasses[] = $socialClasses;

        return $this;
    }

    /**
     * Remove socialClasses
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClass $socialClasses
     */
    public function removeSocialClass(\CorahnRin\CharactersBundle\Entity\SocialClass $socialClasses)
    {
        $this->socialClasses->removeElement($socialClasses);
    }
}

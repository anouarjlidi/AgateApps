<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharSocialClass
 *
 * @ORM\Table(name="char_social_class")
 * @ORM\Entity
 */
class CharSocialClass
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domains1", referencedColumnName="id")
     * })
     */
    private $domain1;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domains2", referencedColumnName="id")
     * })
     */
    private $domain2;

    /**
     * @var \SocialClass
     *
     * @ORM\ManyToOne(targetEntity="SocialClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_social_class", referencedColumnName="id")
     * })
     */
    private $socialClass;


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
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return CharSocialClass
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
     * @return CharSocialClass
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
     * Set domain1
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domain1
     * @return CharSocialClass
     */
    public function setDomain1(\CorahnRin\CharactersBundle\Entity\Domains $domain1 = null)
    {
        $this->domain1 = $domain1;
    
        return $this;
    }

    /**
     * Get domain1
     *
     * @return \CorahnRin\CharactersBundle\Entity\Domains 
     */
    public function getDomain1()
    {
        return $this->domain1;
    }

    /**
     * Set domain2
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domain2
     * @return CharSocialClass
     */
    public function setDomain2(\CorahnRin\CharactersBundle\Entity\Domains $domain2 = null)
    {
        $this->domain2 = $domain2;
    
        return $this;
    }

    /**
     * Get domain2
     *
     * @return \CorahnRin\CharactersBundle\Entity\Domains 
     */
    public function getDomain2()
    {
        return $this->domain2;
    }

    /**
     * Set socialClass
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClass $socialClass
     * @return CharSocialClass
     */
    public function setSocialClass(\CorahnRin\CharactersBundle\Entity\SocialClass $socialClass = null)
    {
        $this->socialClass = $socialClass;
    
        return $this;
    }

    /**
     * Get socialClass
     *
     * @return \CorahnRin\CharactersBundle\Entity\SocialClass 
     */
    public function getSocialClass()
    {
        return $this->socialClass;
    }
}
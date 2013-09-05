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
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domains1", referencedColumnName="id")
     * })
     */
    private $Domains1;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domains2", referencedColumnName="id")
     * })
     */
    private $Domains2;

    /**
     * @var \SocialClass
     *
     * @ORM\ManyToOne(targetEntity="SocialClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_social_class", referencedColumnName="id")
     * })
     */
    private $SocialClass;



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
     * Set Domains1
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domains1
     * @return CharSocialClass
     */
    public function setDomains1(\CorahnRin\CharactersBundle\Entity\Domains $domains1 = null)
    {
        $this->Domains1 = $domains1;
    
        return $this;
    }

    /**
     * Get Domains1
     *
     * @return \CorahnRin\CharactersBundle\Entity\Domains 
     */
    public function getDomains1()
    {
        return $this->Domains1;
    }

    /**
     * Set Domains2
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domains2
     * @return CharSocialClass
     */
    public function setDomains2(\CorahnRin\CharactersBundle\Entity\Domains $domains2 = null)
    {
        $this->Domains2 = $domains2;
    
        return $this;
    }

    /**
     * Get Domains2
     *
     * @return \CorahnRin\CharactersBundle\Entity\Domains 
     */
    public function getDomains2()
    {
        return $this->Domains2;
    }

    /**
     * Set SocialClass
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClass $socialClass
     * @return CharSocialClass
     */
    public function setSocialClass(\CorahnRin\CharactersBundle\Entity\SocialClass $socialClass = null)
    {
        $this->SocialClass = $socialClass;
    
        return $this;
    }

    /**
     * Get SocialClass
     *
     * @return \CorahnRin\CharactersBundle\Entity\SocialClass 
     */
    public function getSocialClass()
    {
        return $this->SocialClass;
    }
}
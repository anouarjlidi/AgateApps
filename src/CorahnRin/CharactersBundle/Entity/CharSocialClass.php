<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharSocialClass
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharSocialClassRepository")
 */
class CharSocialClass
{
    /**
     * @var \Character
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Characters", inversedBy="socialClass")
     */
    private $character;

    /**
     * @var \SocialClass
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="SocialClass")
     */
    private $socialClass;

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
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    private $domain1;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    private $domain2;

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CharSocialClass
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
     * @return CharSocialClass
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
     * Set character
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $character
     * @return CharSocialClass
     */
    public function setCharacter(\CorahnRin\CharactersBundle\Entity\Characters $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return \CorahnRin\CharactersBundle\Entity\Characters
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set socialClass
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClass $socialClass
     * @return CharSocialClass
     */
    public function setSocialClass(\CorahnRin\CharactersBundle\Entity\SocialClass $socialClass)
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
}
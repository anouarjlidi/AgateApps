<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SocialClasses.
 *
 * @ORM\Table(name="social_class")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 */
class SocialClasses
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
     * @ORM\Column(type="string", length=25, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text",nullable=true)
     */
    protected $description;

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
     * @var Domains[]
     *
     * @ORM\ManyToMany(targetEntity="Domains")
     */
    protected $domains;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->domains = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     *
     * @codeCoverageIgnore
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
     * @return SocialClasses
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return SocialClasses
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     * @return SocialClasses
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add domains.
     *
     * @param Domains $domains
     *
     * @return SocialClasses
     */
    public function addDomain(Domains $domains)
    {
        $this->domains[] = $domains;

        return $this;
    }

    /**
     * Remove domains.
     *
     * @param Domains $domains
     */
    public function removeDomain(Domains $domains)
    {
        $this->domains->removeElement($domains);
    }

    /**
     * Get domains.
     *
     * @return Domains[]|ArrayCollection
     *
     * @codeCoverageIgnore
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return SocialClasses
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     * @return SocialClasses
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param int $id
     *
     * @return Domains|null
     */
    public function findDomainById($id)
    {
        $id             = (int) $id;
        $domainToReturn = null;

        foreach ($this->domains as $domain) {
            if ($domain->getId() === $id) {
                $domainToReturn = $domain;
                break;
            }
        }

        return $domainToReturn;
    }

    /**
     * @param int|Domains $domainToCheck
     *
     * @return bool
     */
    public function hasDomain($domainToCheck)
    {
        $id = $domainToCheck instanceof Domains ? $domainToCheck->getId() : $domainToCheck;

        foreach ($this->domains as $domain) {
            if ($domain->getId() === $id) {
                return true;
            }
        }

        return false;
    }
}

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

/**
 * SocialClasses.
 *
 * @ORM\Table(name="social_class")
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\SocialClassesRepository")
 */
class SocialClasses
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id()
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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var Domains[]
     *
     * @ORM\ManyToMany(targetEntity="Domains")
     */
    protected $domains;

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

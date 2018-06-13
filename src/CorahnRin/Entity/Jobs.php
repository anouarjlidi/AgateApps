<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Entity;

use CorahnRin\Entity\Traits\HasBook;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs.
 *
 * @ORM\Table(name="jobs")
 * @ORM\Entity(repositoryClass="CorahnRin\Repository\JobsRepository")
 */
class Jobs
{
    use HasBook;

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
     * @ORM\Column(type="string", length=140, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var int
     *
     * @ORM\Column(name="daily_salary", type="integer", options={"default": "0"})
     */
    protected $dailySalary = 0;

    /**
     * @var Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    protected $domainPrimary;

    /**
     * @var ArrayCollection|Domains[]
     *
     * @ORM\ManyToMany(targetEntity="Domains")
     */
    protected $domainsSecondary;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->domainsSecondary = new ArrayCollection();
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
     * @return Jobs
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
     * Set description.
     *
     * @param string $description
     *
     * @return Jobs
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
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getDailySalary()
    {
        return $this->dailySalary;
    }

    /**
     * @param int $dailySalary
     *
     * @return Jobs
     *
     * @codeCoverageIgnore
     */
    public function setDailySalary($dailySalary)
    {
        $this->dailySalary = $dailySalary;

        return $this;
    }

    /**
     * Set domainPrimary.
     *
     * @param Domains $domainPrimary
     *
     * @return Jobs
     *
     * @codeCoverageIgnore
     */
    public function setDomainPrimary(Domains $domainPrimary = null)
    {
        $this->domainPrimary = $domainPrimary;

        return $this;
    }

    /**
     * Get domainPrimary.
     *
     * @return Domains
     *
     * @codeCoverageIgnore
     */
    public function getDomainPrimary()
    {
        return $this->domainPrimary;
    }

    /**
     * Add domainsSecondary.
     *
     * @param Domains $domainsSecondary
     *
     * @return Jobs
     */
    public function addDomainsSecondary(Domains $domainsSecondary)
    {
        $this->domainsSecondary[] = $domainsSecondary;

        return $this;
    }

    /**
     * Remove domainsSecondary.
     *
     * @param Domains $domainsSecondary
     */
    public function removeDomainsSecondary(Domains $domainsSecondary)
    {
        $this->domainsSecondary->removeElement($domainsSecondary);
    }

    /**
     * Set domainPrimary.
     *
     * @param array|ArrayCollection|Domains[] $domainsSecondary
     *
     * @return Jobs
     */
    public function setDomainsSecondary($domainsSecondary)
    {
        if (!count($domainsSecondary)) {
            foreach ($this->domainsSecondary as $domain) {
                $this->removeDomainsSecondary($domain);
            }
        }

        foreach ($domainsSecondary as $domain) {
            if (!$this->domainsSecondary->contains($domain)) {
                $this->addDomainsSecondary($domain);
            }
        }

        return $this;
    }

    /**
     * Get domainsSecondary.
     *
     * @return Domains[]|ArrayCollection
     *
     * @codeCoverageIgnore
     */
    public function getDomainsSecondary()
    {
        return $this->domainsSecondary;
    }
}

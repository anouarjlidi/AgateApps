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

use CorahnRin\CorahnRinBundle\Entity\Traits\HasBook;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Disciplines.
 *
 * @ORM\Table(name="disciplines")
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\DisciplinesRepository")
 */
class Disciplines
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
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40)
     */
    protected $rank;

    /**
     * @var Domains[]
     *
     * @ORM\ManyToMany(targetEntity="Domains", inversedBy="disciplines")
     * @ORM\JoinTable(name="disciplines_domains",
     *     joinColumns={@ORM\JoinColumn(name="discipline_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="domain_id", referencedColumnName="id")}
     * )
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
     * @return Disciplines
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
     * @return Disciplines
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
     * Set rank.
     *
     * @param string $rank
     *
     * @return Disciplines
     *
     * @codeCoverageIgnore
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Add domains.
     *
     * @param Domains $domains
     *
     * @return Disciplines
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
     * @return Domains[]
     *
     * @codeCoverageIgnore
     */
    public function getDomains()
    {
        return $this->domains;
    }
}

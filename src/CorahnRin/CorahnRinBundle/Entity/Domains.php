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
 * Domains.
 *
 * @ORM\Table(name="domains")
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\DomainsRepository")
 */
class Domains
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
     * @ORM\Column(type="string", length=70, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text",nullable=true)
     */
    protected $description;

    /**
     * @var Ways
     *
     * @ORM\ManyToOne(targetEntity="Ways")
     */
    protected $way;

    /**
     * @var Disciplines[]
     *
     * @ORM\ManyToMany(targetEntity="Disciplines", mappedBy="domains")
     */
    protected $disciplines;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->disciplines = new ArrayCollection();
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
     * @return Domains
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
     * @return Domains
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
     * Set way.
     *
     * @param Ways $way
     *
     * @return Domains
     *
     * @codeCoverageIgnore
     */
    public function setWay(Ways $way = null)
    {
        $this->way = $way;

        return $this;
    }

    /**
     * Get way.
     *
     * @return Ways
     *
     * @codeCoverageIgnore
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * Add disciplines.
     *
     * @param Disciplines $disciplines
     *
     * @return Domains
     */
    public function addDiscipline(Disciplines $disciplines)
    {
        $this->disciplines[] = $disciplines;

        return $this;
    }

    /**
     * Remove disciplines.
     *
     * @param Disciplines $disciplines
     */
    public function removeDiscipline(Disciplines $disciplines)
    {
        $this->disciplines->removeElement($disciplines);
    }

    /**
     * Get disciplines.
     *
     * @return \Doctrine\Common\Collections\Collection
     *
     * @codeCoverageIgnore
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    /**
     * @param Disciplines $discipline
     *
     * @return bool
     */
    public function hasDiscipline(Disciplines $discipline)
    {
        $id = $discipline->getId();

        return $this->disciplines->exists(function ($key, Disciplines $element) use ($id) {
            return $element->getId() === $id;
        });
    }
}

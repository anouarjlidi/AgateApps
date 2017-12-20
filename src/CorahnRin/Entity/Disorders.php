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

use CorahnRin\Entity\CharacterProperties\CharWays;
use CorahnRin\Entity\Traits\HasBook;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Disorders.
 *
 * @ORM\Table(name="disorders")
 * @ORM\Entity(repositoryClass="CorahnRin\Repository\DisordersRepository")
 */
class Disorders
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
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var DisordersWays[]
     *
     * @ORM\OneToMany(targetEntity="DisordersWays", mappedBy="disorder")
     */
    protected $ways;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->ways = new ArrayCollection();
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
     * @return Disorders
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
     * Add ways.
     *
     * @param CharWays $ways
     *
     * @return Disorders
     */
    public function addWay(CharWays $ways)
    {
        $this->ways[] = $ways;

        return $this;
    }

    /**
     * Remove ways.
     *
     * @param CharWays $ways
     */
    public function removeWay(CharWays $ways)
    {
        $this->ways->removeElement($ways);
    }

    /**
     * Get ways.
     *
     * @return DisordersWays[]|ArrayCollection
     *
     * @codeCoverageIgnore
     */
    public function getWays()
    {
        return $this->ways;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Disorders
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
}

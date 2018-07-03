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

use CorahnRin\Data\Ways;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Domains.
 *
 * @ORM\Table(name="domains")
 * @ORM\Entity(repositoryClass="CorahnRin\Repository\DomainsRepository")
 */
class Domains
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
     * @ORM\Column(type="string", length=70, nullable=false, unique=true)
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
     * @ORM\Column(name="way", type="string")
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
        return $this->name;
    }

    public function __construct()
    {
        $this->disciplines = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setWay(string $way)
    {
        Ways::validateWay($way);

        $this->way = $way;

        return $this;
    }

    public function getWay()
    {
        return $this->way;
    }

    public function addDiscipline(Disciplines $disciplines)
    {
        $this->disciplines[] = $disciplines;

        return $this;
    }

    public function removeDiscipline(Disciplines $disciplines)
    {
        $this->disciplines->removeElement($disciplines);
    }

    public function getDisciplines()
    {
        return $this->disciplines;
    }

    public function hasDiscipline(Disciplines $discipline): bool
    {
        $id = $discipline->getId();

        return $this->disciplines->exists(function ($key, Disciplines $element) use ($id) {
            return $element->getId() === $id;
        });
    }
}

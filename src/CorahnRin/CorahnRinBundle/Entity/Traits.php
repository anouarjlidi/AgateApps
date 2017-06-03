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
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Traits.
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\TraitsRepository")
 * @ORM\Table(name="traits",uniqueConstraints={@ORM\UniqueConstraint(name="idxUnique", columns={"name", "way_id"})})
 */
class Traits
{
    use HasBook;

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
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $nameFemale;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isQuality;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isMajor;

    /**
     * @var Ways
     *
     * @ORM\ManyToOne(targetEntity="Ways")
     */
    protected $way;

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
     * @return Traits
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
     * Set nameFemale.
     *
     * @param string $nameFemale
     *
     * @return Traits
     *
     * @codeCoverageIgnore
     */
    public function setNameFemale($nameFemale)
    {
        $this->nameFemale = $nameFemale;

        return $this;
    }

    /**
     * Get nameFemale.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getNameFemale()
    {
        return $this->nameFemale;
    }

    /**
     * Set isQuality.
     *
     * @param bool $isQuality
     *
     * @return Traits
     *
     * @codeCoverageIgnore
     */
    public function setQuality($isQuality)
    {
        $this->isQuality = $isQuality;

        return $this;
    }

    /**
     * Get isQuality.
     *
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function isQuality()
    {
        return $this->isQuality;
    }

    /**
     * Set isMajor.
     *
     * @param bool $isMajor
     *
     * @return Traits
     *
     * @codeCoverageIgnore
     */
    public function setMajor($isMajor)
    {
        $this->isMajor = $isMajor;

        return $this;
    }

    /**
     * Get isMajor.
     *
     * @return bool
     */
    public function isMajor()
    {
        return $this->isMajor;
    }

    /**
     * Set way.
     *
     * @param Ways $way
     *
     * @return Traits
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
}

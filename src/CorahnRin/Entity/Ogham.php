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
use Doctrine\ORM\Mapping as ORM;

/**
 * Ogham.
 *
 * @ORM\Table(name="ogham")
 * @ORM\Entity
 */
class Ogham
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
     * @var OghamTypes
     * @ORM\ManyToOne(targetEntity="OghamTypes")
     */
    protected $oghamType;

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
     * @return Ogham
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
     * @return Ogham
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
     * Set oghamType.
     *
     * @param OghamTypes $oghamType
     *
     * @return Ogham
     *
     * @codeCoverageIgnore
     */
    public function setOghamType(OghamTypes $oghamType = null)
    {
        $this->oghamType = $oghamType;

        return $this;
    }

    /**
     * Get oghamType.
     *
     * @return OghamTypes
     *
     * @codeCoverageIgnore
     */
    public function getOghamType()
    {
        return $this->oghamType;
    }
}

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

use Doctrine\ORM\Mapping as ORM;

/**
 * Ways.
 *
 * @ORM\Table(name="ways")
 * @ORM\Entity()
 */
class Ways
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
     * @ORM\Column(type="string", length=3, nullable=false, unique=true)
     */
    protected $shortName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40, unique=true)
     */
    protected $fault;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
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
     * Set shortName.
     *
     * @param string $shortName
     *
     * @return Ways
     *
     * @codeCoverageIgnore
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Ways
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
     * Set fault.
     *
     * @param string $fault
     *
     * @return Ways
     *
     * @codeCoverageIgnore
     */
    public function setFault($fault)
    {
        $this->fault = $fault;

        return $this;
    }

    /**
     * Get fault.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getFault()
    {
        return $this->fault;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Ways
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

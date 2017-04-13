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
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Miracles.
 *
 * @ORM\Table(name="miracles")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 */
class Miracles
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
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isMajor;

    /**
     * @var Books
     * @ORM\ManyToOne(targetEntity="Books")
     */
    protected $book;

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
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted;

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
     * @return Miracles
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
     * Set isMajor.
     *
     * @param bool $isMajor
     *
     * @return Miracles
     *
     * @codeCoverageIgnore
     */
    public function setIsMajor($isMajor)
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
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Miracles
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
     * @return Miracles
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
     * Set description.
     *
     * @param string $description
     *
     * @return Miracles
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
     * Set book.
     *
     * @param Books $book
     *
     * @return Miracles
     *
     * @codeCoverageIgnore
     */
    public function setBook(Books $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book.
     *
     * @return Books
     *
     * @codeCoverageIgnore
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return Miracles
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
}

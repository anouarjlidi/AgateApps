<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Traits.
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\TraitsRepository")
 * @ORM\Table(name="traits",uniqueConstraints={@ORM\UniqueConstraint(name="idxUnique", columns={"name", "way_id"})})
 */
class Traits
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
     * @ORM\ManyToOne(targetEntity="Ways", fetch="EAGER")
     */
    protected $way;

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
     * @var bool
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * @var Books
     * @ORM\ManyToOne(targetEntity="Books")
     */
    private $book;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
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
     */
    public function setIsQuality($isQuality)
    {
        $this->isQuality = $isQuality;

        return $this;
    }

    /**
     * Get isQuality.
     *
     * @return bool
     */
    public function getIsQuality()
    {
        return $this->isQuality;
    }

    /**
     * Set isMajor.
     *
     * @param bool $isMajor
     *
     * @return Traits
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
     * Set book.
     *
     * @param Books $book
     *
     * @return Traits
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
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Traits
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
     * @return Traits
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
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set way.
     *
     * @param Ways $way
     *
     * @return Traits
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
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return Traits
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
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}

<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharWays;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Disorders.
 *
 * @ORM\Table(name="disorders")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 */
class Disorders
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
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text",nullable=true)
     */
    protected $description;

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
     * @var DisordersWays[]
     *
     * @ORM\OneToMany(targetEntity="DisordersWays", mappedBy="disorder")
     */
    protected $ways;

    /**
     * @var Books
     * @ORM\ManyToOne(targetEntity="Books", fetch="EAGER")
     */
    protected $book;

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
     * @return Disorders
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
     * Set book.
     *
     * @param Books $book
     *
     * @return $this
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
     * @return Disorders
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
     * @return Disorders
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
     * @return \Doctrine\Common\Collections\Collection
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
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return Disorders
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

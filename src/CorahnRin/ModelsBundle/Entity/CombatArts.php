<?php

namespace CorahnRin\ModelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CombatArts
 *
 * @ORM\Table(name="combat_arts")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\ModelsBundle\Repository\CombatArtsRepository")
 */
class CombatArts {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ranged", type="boolean")
     */
    private $ranged;

    /**
     * @var boolean
     *
     * @ORM\Column(name="melee", type="boolean")
     */
    private $melee;

    /**
     * @var integer
     *
     * @ORM\Column(name="xp", type="smallint")
     */
    private $xp;

    /**
     * @var Books
     * @ORM\ManyToOne(targetEntity="Books", fetch="EAGER")
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
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CombatArts
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CombatArts
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set ranged
     *
     * @param boolean $ranged
     * @return CombatArts
     */
    public function setRanged($ranged) {
        $this->ranged = $ranged;

        return $this;
    }

    /**
     * Get ranged
     *
     * @return boolean
     */
    public function getRanged() {
        return $this->ranged;
    }

    /**
     * Set melee
     *
     * @param boolean $melee
     * @return CombatArts
     */
    public function setMelee($melee) {
        $this->melee = $melee;

        return $this;
    }

    /**
     * Get melee
     *
     * @return boolean
     */
    public function getMelee() {
        return $this->melee;
    }

    /**
     * Set xp
     *
     * @param integer $xp
     * @return CombatArts
     */
    public function setXp($xp) {
        $this->xp = $xp;

        return $this;
    }

    /**
     * Get xp
     *
     * @return integer
     */
    public function getXp() {
        return $this->xp;
    }

    /**
     * Set book
     *
     * @param Books $book
     * @return Avantages
     */
    public function setBook(Books $book = null) {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return Books
     */
    public function getBook() {
        return $this->book;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CombatArts
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return CombatArts
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return CombatArts
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted() {
        return $this->deleted;
    }
}

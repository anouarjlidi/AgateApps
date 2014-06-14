<?php

namespace CorahnRin\ModelsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Domains
 *
 * @ORM\Table(name="domains")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\ModelsBundle\Repository\DomainsRepository")
 */
class Domains {
    /**
     * @var integer
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

    function __toString() {
        return $this->id . ' - ' . $this->name;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->disciplines = new ArrayCollection();
    }

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
     * @return Domains
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
     * @return Domains
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
     * Set created
     *
     * @param \DateTime $created
     * @return Domains
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
     * @return Domains
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
     * Set way
     *
     * @param Ways $way
     * @return Domains
     */
    public function setWay(Ways $way = null) {
        $this->way = $way;

        return $this;
    }

    /**
     * Get way
     *
     * @return Ways
     */
    public function getWay() {
        return $this->way;
    }

    /**
     * Add disciplines
     *
     * @param Disciplines $disciplines
     * @return Domains
     */
    public function addDiscipline(Disciplines $disciplines) {
        $this->disciplines[] = $disciplines;

        return $this;
    }

    /**
     * Remove disciplines
     *
     * @param Disciplines $disciplines
     */
    public function removeDiscipline(Disciplines $disciplines) {
        $this->disciplines->removeElement($disciplines);
    }

    /**
     * Get disciplines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisciplines() {
        return $this->disciplines;
    }
}

<?php

namespace CorahnRin\ModelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Traits
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\ModelsBundle\Repository\TraitsRepository")
 * @ORM\Table(name="traits",uniqueConstraints={@ORM\UniqueConstraint(name="idxUnique", columns={"name", "way_id"})})
 */
class Traits {

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
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $isQuality;

    /**
     * @var boolean
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
     * @return Traits
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
     * Set nameFemale
     *
     * @param string $nameFemale
     * @return Traits
     */
    public function setNameFemale($nameFemale) {
        $this->nameFemale = $nameFemale;

        return $this;
    }

    /**
     * Get nameFemale
     *
     * @return string
     */
    public function getNameFemale() {
        return $this->nameFemale;
    }

    /**
     * Set isQuality
     *
     * @param boolean $isQuality
     * @return Traits
     */
    public function setIsQuality($isQuality) {
        $this->isQuality = $isQuality;

        return $this;
    }

    /**
     * Get isQuality
     *
     * @return boolean
     */
    public function getIsQuality() {
        return $this->isQuality;
    }

    /**
     * Set isMajor
     *
     * @param boolean $isMajor
     * @return Traits
     */
    public function setIsMajor($isMajor) {
        $this->isMajor = $isMajor;

        return $this;
    }

    /**
     * Get isMajor
     *
     * @return boolean
     */
    public function isMajor() {
        return $this->isMajor;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Traits
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
     * @return Traits
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
     * @return Traits
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
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return Traits
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

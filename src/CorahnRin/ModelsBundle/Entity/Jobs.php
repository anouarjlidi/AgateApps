<?php

namespace CorahnRin\ModelsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Table(name="jobs")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\ModelsBundle\Repository\JobsRepository")
 */
class Jobs {
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
     * @ORM\Column(type="string", length=140, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text",nullable=true)
     */
    protected $description;

    /**
     * @var Books
     *
     * @ORM\ManyToOne(targetEntity="Books",fetch="EAGER")
     */
    protected $book;

    /**
     * @var Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains",fetch="EAGER")
     */
    protected $domainPrimary;

    /**
     * @var Domains
     *
     * @ORM\ManyToMany(targetEntity="Domains")
     */
    protected $domainsSecondary;

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
     * @return Jobs
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
     * @return Jobs
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
     * @return Jobs
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
     * @return Jobs
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
     * Set book
     *
     * @param Books $book
     * @return Jobs
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
     * Constructor
     */
    public function __construct() {
        $this->domainsSecondary = new ArrayCollection();
    }

    /**
     * Set domainPrimary
     *
     * @param Domains $domainPrimary
     * @return Jobs
     */
    public function setDomainPrimary(Domains $domainPrimary = null) {
        $this->domainPrimary = $domainPrimary;

        return $this;
    }

    /**
     * Get domainPrimary
     *
     * @return Domains
     */
    public function getDomainPrimary() {
        return $this->domainPrimary;
    }

    /**
     * Add domainsSecondary
     *
     * @param Domains $domainsSecondary
     * @return Jobs
     */
    public function addDomainsSecondary(Domains $domainsSecondary) {
        $this->domainsSecondary[] = $domainsSecondary;

        return $this;
    }

    /**
     * Remove domainsSecondary
     *
     * @param Domains $domainsSecondary
     */
    public function removeDomainsSecondary(Domains $domainsSecondary) {
        $this->domainsSecondary->removeElement($domainsSecondary);
    }

    /**
     * Get domainsSecondary
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDomainsSecondary() {
        return $this->domainsSecondary;
    }
}

<?php

namespace CorahnRin\CharactersBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Disciplines
 *
 * @ORM\Table(name="disciplines")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\DisciplinesRepository")
 */
class Disciplines
{
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
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text",nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40)
     */
    protected $rank;

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
     * @var Books
     * @ORM\ManyToOne(targetEntity="Books", fetch="EAGER")
     */
    protected $book;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Domains", inversedBy="disciplines")
     * @ORM\JoinTable(name="disciplines_domains",
     *      joinColumns={@JoinColumn(name="discipline_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="domain_id", referencedColumnName="id")}
     *  )
     */
    protected $domains;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->domains = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Disciplines
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Disciplines
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set rank
     *
     * @param string $rank
     * @return Disciplines
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Disciplines
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Disciplines
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set book
     *
     * @param \CorahnRin\CharactersBundle\Entity\Books $book
     * @return Disciplines
     */
    public function setBook(\CorahnRin\CharactersBundle\Entity\Books $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \CorahnRin\CharactersBundle\Entity\Books
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Add domains
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domains
     * @return Disciplines
     */
    public function addDomain(\CorahnRin\CharactersBundle\Entity\Domains $domains)
    {
        $this->domains[] = $domains;

        return $this;
    }

    /**
     * Remove domains
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domains
     */
    public function removeDomain(\CorahnRin\CharactersBundle\Entity\Domains $domains)
    {
        $this->domains->removeElement($domains);
    }

    /**
     * Get domains
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDomains()
    {
        return $this->domains;
    }
}

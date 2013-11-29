<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\JobsRepository")
 */
class Jobs
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=140, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

    /**
     * @var \Datetime
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \Datetime

     * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @var \Books
     *
     * @ORM\ManyToOne(targetEntity="Books")
     */
    private $book;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    private $domainPrimary;

    /**
     * @var \Domains
     *
     * @ORM\ManyToMany(targetEntity="Domains")
     */
    private $domainsSecondary;


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
     * @return Jobs
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
     * @return Jobs
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
     * Set created
     *
     * @param \DateTime $created
     * @return Jobs
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
     * @return Jobs
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
     * @return Jobs
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
     * Constructor
     */
    public function __construct()
    {
        $this->domainsSecondary = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set domainPrimary
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domainPrimary
     * @return Jobs
     */
    public function setDomainPrimary(\CorahnRin\CharactersBundle\Entity\Domains $domainPrimary = null)
    {
        $this->domainPrimary = $domainPrimary;

        return $this;
    }

    /**
     * Get domainPrimary
     *
     * @return \CorahnRin\CharactersBundle\Entity\Domains 
     */
    public function getDomainPrimary()
    {
        return $this->domainPrimary;
    }

    /**
     * Add domainsSecondary
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domainsSecondary
     * @return Jobs
     */
    public function addDomainsSecondary(\CorahnRin\CharactersBundle\Entity\Domains $domainsSecondary)
    {
        $this->domainsSecondary[] = $domainsSecondary;

        return $this;
    }

    /**
     * Remove domainsSecondary
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domainsSecondary
     */
    public function removeDomainsSecondary(\CorahnRin\CharactersBundle\Entity\Domains $domainsSecondary)
    {
        $this->domainsSecondary->removeElement($domainsSecondary);
    }

    /**
     * Get domainsSecondary
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDomainsSecondary()
    {
        return $this->domainsSecondary;
    }
}

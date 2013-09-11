<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Table(name="jobs")
 * @ORM\Entity
 */
class Jobs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=140, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var \Books
     *
     * @ORM\ManyToOne(targetEntity="Books")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_books", referencedColumnName="id")
     * })
     */
    private $Books;



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
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return Jobs
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return integer 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param integer $dateUpdated
     * @return Jobs
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    
        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return integer 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set Books
     *
     * @param \CorahnRin\CharactersBundle\Entity\Books $books
     * @return Jobs
     */
    public function setBooks(\CorahnRin\CharactersBundle\Entity\Books $books = null)
    {
        $this->Books = $books;
    
        return $this;
    }

    /**
     * Get Books
     *
     * @return \CorahnRin\CharactersBundle\Entity\Books 
     */
    public function getBooks()
    {
        return $this->Books;
    }
}
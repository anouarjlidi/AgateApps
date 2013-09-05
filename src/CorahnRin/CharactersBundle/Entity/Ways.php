<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ways
 *
 * @ORM\Table(name="ways")
 * @ORM\Entity
 */
class Ways
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=3, nullable=false)
     */
    private $shortName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="fault", type="string", length=40, nullable=false)
     */
    private $fault;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="date_created", type="integer", nullable=false)
     */
    private $dateCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="date_updated", type="integer", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Characters", mappedBy="Ways")
     */
    private $Characters;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Desordres", mappedBy="Ways")
     */
    private $Desordres;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Characters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Desordres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set shortName
     *
     * @param string $shortName
     * @return Ways
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    
        return $this;
    }

    /**
     * Get shortName
     *
     * @return string 
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Ways
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
     * Set fault
     *
     * @param string $fault
     * @return Ways
     */
    public function setFault($fault)
    {
        $this->fault = $fault;
    
        return $this;
    }

    /**
     * Get fault
     *
     * @return string 
     */
    public function getFault()
    {
        return $this->fault;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Ways
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
     * @return Ways
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
     * @return Ways
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
     * Add Characters
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $characters
     * @return Ways
     */
    public function addCharacter(\CorahnRin\CharactersBundle\Entity\Characters $characters)
    {
        $this->Characters[] = $characters;
    
        return $this;
    }

    /**
     * Remove Characters
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $characters
     */
    public function removeCharacter(\CorahnRin\CharactersBundle\Entity\Characters $characters)
    {
        $this->Characters->removeElement($characters);
    }

    /**
     * Get Characters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCharacters()
    {
        return $this->Characters;
    }

    /**
     * Add Desordres
     *
     * @param \CorahnRin\CharactersBundle\Entity\Desordres $desordres
     * @return Ways
     */
    public function addDesordre(\CorahnRin\CharactersBundle\Entity\Desordres $desordres)
    {
        $this->Desordres[] = $desordres;
    
        return $this;
    }

    /**
     * Remove Desordres
     *
     * @param \CorahnRin\CharactersBundle\Entity\Desordres $desordres
     */
    public function removeDesordre(\CorahnRin\CharactersBundle\Entity\Desordres $desordres)
    {
        $this->Desordres->removeElement($desordres);
    }

    /**
     * Get Desordres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDesordres()
    {
        return $this->Desordres;
    }
}
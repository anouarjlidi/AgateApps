<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avantages
 *
 * @ORM\Table(name="avantages")
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\AvantagesRepository")
 */
class Avantages
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
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $nameFemale;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $xp;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $description;

    /**
     * @var boolean
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $double;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    protected $bonusdisc;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isDesv;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isCombatArt;

    /**
     * @var \Datetime
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime

     * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var \Books
     * @ORM\ManyToOne(targetEntity="Books")
     */
    protected $book;


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
     * @return Avantages
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
     * Set nameFemale
     *
     * @param string $nameFemale
     * @return Avantages
     */
    public function setNameFemale($nameFemale)
    {
        $this->nameFemale = $nameFemale;

        return $this;
    }

    /**
     * Get nameFemale
     *
     * @return string
     */
    public function getNameFemale()
    {
        return $this->nameFemale;
    }

    /**
     * Set xp
     *
     * @param integer $xp
     * @return Avantages
     */
    public function setXp($xp)
    {
        $this->xp = $xp;

        return $this;
    }

    /**
     * Get xp
     *
     * @return integer
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Avantages
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
     * Set double
     *
     * @param integer $double
     * @return Avantages
     */
    public function setDouble($double)
    {
        $this->double = $double;

        return $this;
    }

    /**
     * Get double
     *
     * @return integer
     */
    public function getDouble()
    {
        return $this->double;
    }

    /**
     * Set bonusdisc
     *
     * @param string $bonusdisc
     * @return Avantages
     */
    public function setBonusdisc($bonusdisc)
    {
        $this->bonusdisc = $bonusdisc;

        return $this;
    }

    /**
     * Get bonusdisc
     *
     * @return string
     */
    public function getBonusdisc()
    {
        return $this->bonusdisc;
    }

    /**
     * Set isDesv
     *
     * @param boolean $isDesv
     * @return Avantages
     */
    public function setIsDesv($isDesv)
    {
        $this->isDesv = $isDesv;

        return $this;
    }

    /**
     * Get isDesv
     *
     * @return boolean
     */
    public function getIsDesv()
    {
        return $this->isDesv;
    }

    /**
     * Set isCombatArt
     *
     * @param boolean $isCombatArt
     * @return Avantages
     */
    public function setIsCombatArt($isCombatArt)
    {
        $this->isCombatArt = $isCombatArt;

        return $this;
    }

    /**
     * Get isCombatArt
     *
     * @return boolean
     */
    public function getIsCombatArt()
    {
        return $this->isCombatArt;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Avantages
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
     * @return Avantages
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
     * @return Avantages
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
}

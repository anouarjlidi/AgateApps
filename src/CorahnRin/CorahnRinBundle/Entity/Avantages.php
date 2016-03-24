<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Avantages.
 *
 * @ORM\Table(name="avantages")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\AvantagesRepository")
 */
class Avantages
{
    const BONUS_100G = '100g';
    const BONUS_50G = '50g';
    const BONUS_20G = '20g';
    const BONUS_50A = '50a';
    const BONUS_20A = '20a';
    const BONUS_RESM = 'resm';
    const BONUS_BLESS = 'bless';
    const BONUS_VIG = 'vig';
    const BONUS_TRAU = 'trau';
    const BONUS_DEF = 'def';
    const BONUS_RAP = 'rap';
    const BONUS_SUR = 'sur';

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
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $xp;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var bool
     *
     * @ORM\Column(type="smallint")
     */
    protected $augmentation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    protected $bonusdisc;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isDesv;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isCombatArt;

    /**
     * @var int
     *
     * @ORM\Column(name="avtg_group", type="smallint", options={"default"="0"}, nullable=true)
     */
    protected $group = 0;

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
     * @var bool
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

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
     * @return Avantages
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
     * Set nameFemale.
     *
     * @param string $nameFemale
     *
     * @return Avantages
     */
    public function setNameFemale($nameFemale)
    {
        $this->nameFemale = $nameFemale;

        return $this;
    }

    /**
     * Get nameFemale.
     *
     * @return string
     */
    public function getNameFemale()
    {
        return $this->nameFemale;
    }

    /**
     * Set xp.
     *
     * @param int $xp
     *
     * @return Avantages
     */
    public function setXp($xp)
    {
        $this->xp = $xp;

        return $this;
    }

    /**
     * Get xp.
     *
     * @return int
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Avantages
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
     * Set bonusdisc.
     *
     * @param string $bonusdisc
     *
     * @return Avantages
     */
    public function setBonusdisc($bonusdisc)
    {
        $this->bonusdisc = $bonusdisc;

        return $this;
    }

    /**
     * Get bonusdisc.
     *
     * @return string
     */
    public function getBonusdisc()
    {
        return $this->bonusdisc;
    }

    /**
     * Set isDesv.
     *
     * @param bool $isDesv
     *
     * @return Avantages
     */
    public function setIsDesv($isDesv)
    {
        $this->isDesv = $isDesv;

        return $this;
    }

    /**
     * Get isDesv.
     *
     * @return bool
     */
    public function getIsDesv()
    {
        return $this->isDesv;
    }

    /**
     * Set isCombatArt.
     *
     * @param bool $isCombatArt
     *
     * @return Avantages
     */
    public function setIsCombatArt($isCombatArt)
    {
        $this->isCombatArt = $isCombatArt;

        return $this;
    }

    /**
     * Get isCombatArt.
     *
     * @return bool
     */
    public function getIsCombatArt()
    {
        return $this->isCombatArt;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Avantages
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
     * @return Avantages
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
     * Set book.
     *
     * @param Books $book
     *
     * @return Avantages
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
     * Set augmentation.
     *
     * @param int $augmentation
     *
     * @return Avantages
     */
    public function setAugmentation($augmentation)
    {
        $this->augmentation = $augmentation;

        return $this;
    }

    /**
     * Get augmentation.
     *
     * @return int
     */
    public function getAugmentation()
    {
        return $this->augmentation;
    }

    /**
     * Set group.
     *
     * @param int $group
     *
     * @return Avantages
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group.
     *
     * @return int
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return Avantages
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

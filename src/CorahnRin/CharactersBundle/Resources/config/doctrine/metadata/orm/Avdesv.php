<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Avdesv
 *
 * @ORM\Table(name="avdesv")
 * @ORM\Entity
 */
class Avdesv
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_female", type="string", length=50, nullable=false)
     */
    private $nameFemale;

    /**
     * @var integer
     *
     * @ORM\Column(name="xp", type="integer", nullable=false)
     */
    private $xp;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="can_be_doubled", type="boolean", nullable=false)
     */
    private $canBeDoubled;

    /**
     * @var string
     *
     * @ORM\Column(name="bonusdisc", type="string", length=10, nullable=false)
     */
    private $bonusdisc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_desv", type="boolean", nullable=false)
     */
    private $isDesv;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_combat_art", type="boolean", nullable=false)
     */
    private $isCombatArt;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Characters", inversedBy="idAvdesv")
     * @ORM\JoinTable(name="char_avtgs",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_avdesv", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   }
     * )
     */
    private $idCharacters;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCharacters = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}

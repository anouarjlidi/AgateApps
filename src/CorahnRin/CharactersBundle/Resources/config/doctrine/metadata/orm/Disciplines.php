<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Disciplines
 *
 * @ORM\Table(name="disciplines")
 * @ORM\Entity
 */
class Disciplines
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
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="rank", type="string", length=40, nullable=false)
     */
    private $rank;

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
     * @ORM\ManyToMany(targetEntity="Characters", inversedBy="idDisciplines")
     * @ORM\JoinTable(name="char_disciplines",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_disciplines", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   }
     * )
     */
    private $idCharacters;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Domains", inversedBy="idDisciplines")
     * @ORM\JoinTable(name="discipline_domains",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_disciplines", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_domains", referencedColumnName="id")
     *   }
     * )
     */
    private $idDomains;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCharacters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idDomains = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}

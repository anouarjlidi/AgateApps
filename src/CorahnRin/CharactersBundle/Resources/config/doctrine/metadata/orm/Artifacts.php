<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Artifacts
 *
 * @ORM\Table(name="artifacts")
 * @ORM\Entity
 */
class Artifacts
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
     * @ORM\Column(name="name", type="string", length=70, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="consumption_value", type="integer", nullable=false)
     */
    private $consumptionValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="consuption_interval", type="integer", nullable=false)
     */
    private $consuptionInterval;

    /**
     * @var integer
     *
     * @ORM\Column(name="tank", type="integer", nullable=false)
     */
    private $tank;

    /**
     * @var integer
     *
     * @ORM\Column(name="resistance", type="integer", nullable=false)
     */
    private $resistance;

    /**
     * @var string
     *
     * @ORM\Column(name="vulnerability", type="string", length=70, nullable=false)
     */
    private $vulnerability;

    /**
     * @var string
     *
     * @ORM\Column(name="handling", type="string", length=20, nullable=false)
     */
    private $handling;

    /**
     * @var integer
     *
     * @ORM\Column(name="damage", type="integer", nullable=false)
     */
    private $damage;

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
     * @ORM\ManyToMany(targetEntity="Characters", mappedBy="idArtifacts")
     */
    private $idCharacters;

    /**
     * @var \Flux
     *
     * @ORM\ManyToOne(targetEntity="Flux")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_flux", referencedColumnName="id")
     * })
     */
    private $idFlux;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCharacters = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}

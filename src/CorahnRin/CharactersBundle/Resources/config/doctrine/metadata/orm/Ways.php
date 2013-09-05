<?php



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
     * @ORM\ManyToMany(targetEntity="Characters", mappedBy="idWays")
     */
    private $idCharacters;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Desordres", mappedBy="idWays")
     */
    private $idDesordres;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCharacters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idDesordres = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}

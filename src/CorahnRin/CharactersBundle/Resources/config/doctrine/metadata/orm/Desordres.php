<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Desordres
 *
 * @ORM\Table(name="desordres")
 * @ORM\Entity
 */
class Desordres
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
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

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
     * @ORM\ManyToMany(targetEntity="Ways", inversedBy="idDesordres")
     * @ORM\JoinTable(name="disorder_ways",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_desordres", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ways", referencedColumnName="id")
     *   }
     * )
     */
    private $idWays;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idWays = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}

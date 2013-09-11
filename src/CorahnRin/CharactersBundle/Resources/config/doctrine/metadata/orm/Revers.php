<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Revers
 *
 * @ORM\Table(name="revers")
 * @ORM\Entity
 */
class Revers
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
     * @ORM\ManyToMany(targetEntity="Characters", inversedBy="idRevers")
     * @ORM\JoinTable(name="character_revers",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_revers", referencedColumnName="id")
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

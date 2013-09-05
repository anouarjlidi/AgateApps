<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Miracles
 *
 * @ORM\Table(name="miracles")
 * @ORM\Entity
 */
class Miracles
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
     * @var boolean
     *
     * @ORM\Column(name="is_major", type="boolean", nullable=false)
     */
    private $isMajor;

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
     * @ORM\ManyToMany(targetEntity="Characters", inversedBy="idMiracles")
     * @ORM\JoinTable(name="char_miracles",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_miracles", referencedColumnName="id")
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

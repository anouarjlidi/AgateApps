<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SocialClass
 *
 * @ORM\Table(name="social_class")
 * @ORM\Entity
 */
class SocialClass
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
     * @ORM\Column(name="name", type="string", length=25, nullable=false)
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
     * @ORM\ManyToMany(targetEntity="Domains", inversedBy="idSocialClass")
     * @ORM\JoinTable(name="social_class_domains",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_social_class", referencedColumnName="id")
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
        $this->idDomains = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}

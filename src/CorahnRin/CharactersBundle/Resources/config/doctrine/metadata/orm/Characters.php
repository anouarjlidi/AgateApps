<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Characters
 *
 * @ORM\Table(name="characters")
 * @ORM\Entity
 */
class Characters
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=1, nullable=false)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="inventory", type="text", nullable=false)
     */
    private $inventory;

    /**
     * @var string
     *
     * @ORM\Column(name="money", type="string", length=150, nullable=false)
     */
    private $money;

    /**
     * @var string
     *
     * @ORM\Column(name="orientation", type="string", length=30, nullable=false)
     */
    private $orientation;

    /**
     * @var string
     *
     * @ORM\Column(name="char_content", type="text", nullable=false)
     */
    private $charContent;

    /**
     * @var string
     *
     * @ORM\Column(name="geo_living", type="string", length=25, nullable=false)
     */
    private $geoLiving;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private $age;

    /**
     * @var integer
     *
     * @ORM\Column(name="mental_resist", type="integer", nullable=false)
     */
    private $mentalResist;

    /**
     * @var integer
     *
     * @ORM\Column(name="health", type="integer", nullable=false)
     */
    private $health;

    /**
     * @var integer
     *
     * @ORM\Column(name="stamina", type="integer", nullable=false)
     */
    private $stamina;

    /**
     * @var boolean
     *
     * @ORM\Column(name="survival", type="boolean", nullable=false)
     */
    private $survival;

    /**
     * @var integer
     *
     * @ORM\Column(name="speed", type="integer", nullable=false)
     */
    private $speed;

    /**
     * @var integer
     *
     * @ORM\Column(name="defense", type="integer", nullable=false)
     */
    private $defense;

    /**
     * @var integer
     *
     * @ORM\Column(name="rindath", type="integer", nullable=false)
     */
    private $rindath;

    /**
     * @var integer
     *
     * @ORM\Column(name="exaltation", type="integer", nullable=false)
     */
    private $exaltation;

    /**
     * @var integer
     *
     * @ORM\Column(name="experience_actual", type="integer", nullable=false)
     */
    private $experienceActual;

    /**
     * @var integer
     *
     * @ORM\Column(name="experience_spent", type="integer", nullable=false)
     */
    private $experienceSpent;

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
     * @ORM\ManyToMany(targetEntity="Armors", inversedBy="idCharacters")
     * @ORM\JoinTable(name="char_armors",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_armors", referencedColumnName="id")
     *   }
     * )
     */
    private $idArmors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Artifacts", inversedBy="idCharacters")
     * @ORM\JoinTable(name="char_artifacts",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_artifacts", referencedColumnName="id")
     *   }
     * )
     */
    private $idArtifacts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Avdesv", mappedBy="idCharacters")
     */
    private $idAvdesv;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Disciplines", mappedBy="idCharacters")
     */
    private $idDisciplines;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Domains", inversedBy="idCharacters")
     * @ORM\JoinTable(name="char_domains",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_domains", referencedColumnName="id")
     *   }
     * )
     */
    private $idDomains;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Flux", inversedBy="idCharacters")
     * @ORM\JoinTable(name="char_flux",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_flux", referencedColumnName="id")
     *   }
     * )
     */
    private $idFlux;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Miracles", mappedBy="idCharacters")
     */
    private $idMiracles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ogham", inversedBy="idCharacters")
     * @ORM\JoinTable(name="char_ogham",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ogham", referencedColumnName="id")
     *   }
     * )
     */
    private $idOgham;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ways", inversedBy="idCharacters")
     * @ORM\JoinTable(name="char_ways",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ways", referencedColumnName="id")
     *   }
     * )
     */
    private $idWays;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Weapons", inversedBy="idCharacters")
     * @ORM\JoinTable(name="char_weapons",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_weapons", referencedColumnName="id")
     *   }
     * )
     */
    private $idWeapons;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Revers", mappedBy="idCharacters")
     */
    private $idRevers;

    /**
     * @var \CharSocialClass
     *
     * @ORM\ManyToOne(targetEntity="CharSocialClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_char_social_class", referencedColumnName="id")
     * })
     */
    private $idCharSocialClass;

    /**
     * @var \Desordres
     *
     * @ORM\ManyToOne(targetEntity="Desordres")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_desordres", referencedColumnName="id")
     * })
     */
    private $idDesordres;

    /**
     * @var \Jobs
     *
     * @ORM\ManyToOne(targetEntity="Jobs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_jobs", referencedColumnName="id")
     * })
     */
    private $idJobs;

    /**
     * @var \Regions
     *
     * @ORM\ManyToOne(targetEntity="Regions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_regions", referencedColumnName="id")
     * })
     */
    private $idRegions;

    /**
     * @var \Traits
     *
     * @ORM\ManyToOne(targetEntity="Traits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_traits_flaw", referencedColumnName="id")
     * })
     */
    private $idTraitsFlaw;

    /**
     * @var \Traits
     *
     * @ORM\ManyToOne(targetEntity="Traits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_traits_quality", referencedColumnName="id")
     * })
     */
    private $idTraitsQuality;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\UsersBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_users", referencedColumnName="id")
     * })
     */
    private $idUsers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idArmors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idArtifacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idAvdesv = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idDisciplines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idDomains = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idFlux = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idMiracles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idOgham = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idWays = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idWeapons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idRevers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}

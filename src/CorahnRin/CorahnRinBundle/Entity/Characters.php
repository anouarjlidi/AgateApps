<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use CorahnRin\CorahnRinBundle\Classes\Money;
use CorahnRin\CorahnRinBundle\Exception\CharactersException;
use UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Characters.
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\CharactersRepository")
 * @ORM\Table(name="characters",uniqueConstraints={@ORM\UniqueConstraint(name="idcUnique", columns={"name", "user_id"})})
 */
class Characters
{
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
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Gedmo\Slug(fields={"name"},unique=false)
     * @Assert\NotBlank()
     */
    protected $nameSlug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $playerName;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=false, options={"default":0})
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1, nullable=false)
     */
    protected $sex;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $story;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $facts;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    protected $inventory;

    /**
     * @var \CorahnRin\CorahnRinBundle\Classes\Money
     *
     * @ORM\Column(type="object")
     */
    protected $money;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     */
    protected $orientation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    protected $jobCustom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     */
    protected $geoLiving;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"default":0})
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $trauma = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"default":0})
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $traumaPermanent = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"default":0})
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $hardening = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=false)
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $age;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $mentalResist;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $health;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $maxHealth;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $stamina;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $survival;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $speed;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $defense;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $rindath;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $exaltation;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $experienceActual;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $experienceSpent;

    /**
     * @var Peoples
     *
     * @ORM\ManyToOne(targetEntity="Peoples")
     */
    protected $people;

    /**
     * @var Armors[]
     *
     * @ORM\ManyToMany(targetEntity="Armors")
     */
    protected $armors;

    /**
     * @var Artifacts[]
     *
     * @ORM\ManyToMany(targetEntity="Artifacts")
     */
    protected $artifacts;

    /**
     * @var Miracles[]
     *
     * @ORM\ManyToMany(targetEntity="Miracles")
     */
    protected $miracles;

    /**
     * @var Ogham[]
     *
     * @ORM\ManyToMany(targetEntity="Ogham")
     */
    protected $ogham;

    /**
     * @var Weapons[]
     *
     * @ORM\ManyToMany(targetEntity="Weapons")
     */
    protected $weapons;

    /**
     * @var SocialClasses
     *
     * @ORM\ManyToOne(targetEntity="SocialClasses", fetch="EAGER")
     */
    protected $socialClasses;

    /**
     * @var Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    protected $SocialClassDomain1;

    /**
     * @var Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    protected $SocialClassDomain2;

    /**
     * @var Disorders
     *
     * @ORM\ManyToOne(targetEntity="Disorders")
     */
    protected $disorder;

    /**
     * @var Jobs
     *
     * @ORM\ManyToOne(targetEntity="Jobs", fetch="EAGER")
     */
    protected $job;

    /**
     * @var Regions
     *
     * @ORM\ManyToOne(targetEntity="Regions", fetch="EAGER")
     */
    protected $region;

    /**
     * @var Traits
     * @ORM\ManyToOne(targetEntity="Traits")
     */
    protected $traitFlaw;

    /**
     * @var Traits
     * @ORM\ManyToOne(targetEntity="Traits")
     */
    protected $traitQuality;

    /**
     * @var Avantages[]
     *
     * @ORM\OneToMany(targetEntity="CharAvtgs", mappedBy="character")
     */
    protected $avantages;

    /**
     * @var Domains[]
     *
     * @ORM\OneToMany(targetEntity="CharDomains", mappedBy="character")
     */
    protected $domains;

    /**
     * @var Disciplines[]
     *
     * @ORM\OneToMany(targetEntity="CharDisciplines", mappedBy="character")
     */
    protected $disciplines;

    /**
     * @var Ways[]
     *
     * @ORM\OneToMany(targetEntity="CharWays", mappedBy="character")
     */
    protected $ways;

    /**
     * @var Flux[]
     *
     * @ORM\OneToMany(targetEntity="CharFlux", mappedBy="character")
     */
    protected $flux;

    /**
     * @var CharModifications
     *
     * @ORM\OneToMany(targetEntity="CharModifications", mappedBy="character")
     */
    protected $modifications;

    /**
     * @var Setbacks[]
     *
     * @ORM\OneToMany(targetEntity="CharSetbacks", mappedBy="character")
     */
    protected $setbacks;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", fetch="EAGER")
     */
    protected $user;

    /**
     * @var Games
     * @ORM\ManyToOne(targetEntity="Games", inversedBy="characters", fetch="EAGER")
     */
    protected $game;

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
     * Utilisé pour déterminer les différences lorsque le personnage sera mis à jour.
     *
     * @var Characters
     */
    protected $baseChar;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->armors = new ArrayCollection();
        $this->artifacts = new ArrayCollection();
        $this->miracles = new ArrayCollection();
        $this->ogham = new ArrayCollection();
        $this->weapons = new ArrayCollection();
        $this->avantages = new ArrayCollection();
        $this->domains = new ArrayCollection();
        $this->disciplines = new ArrayCollection();
        $this->ways = new ArrayCollection();
        $this->flux = new ArrayCollection();
        $this->modifications = new ArrayCollection();
        $this->setbacks = new ArrayCollection();
    }

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
     * @return Characters
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
     * Set nameSlug.
     *
     * @param string $nameSlug
     *
     * @return Characters
     */
    public function setNameSlug($nameSlug)
    {
        $this->nameSlug = $nameSlug;

        return $this;
    }

    /**
     * Get nameSlug.
     *
     * @return string
     */
    public function getNameSlug()
    {
        return $this->nameSlug;
    }

    /**
     * Set playerName.
     *
     * @param string $playerName
     *
     * @return Characters
     */
    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;

        return $this;
    }

    /**
     * Get playerName.
     *
     * @return string
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return Characters
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set sex.
     *
     * @param string $sex
     *
     * @return Characters
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex.
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Characters
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
     * Set story.
     *
     * @param string $story
     *
     * @return Characters
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story.
     *
     * @return string
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set facts.
     *
     * @param string $facts
     *
     * @return Characters
     */
    public function setFacts($facts)
    {
        $this->facts = $facts;

        return $this;
    }

    /**
     * Get facts.
     *
     * @return string
     */
    public function getFacts()
    {
        return $this->facts;
    }

    /**
     * Set inventory.
     *
     * @param array $inventory
     *
     * @return Characters
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory.
     *
     * @return array
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set money.
     *
     * @param Money $money
     *
     * @return Characters
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money.
     *
     * @return Money
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set orientation.
     *
     * @param string $orientation
     *
     * @return Characters
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation.
     *
     * @return string
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Get conscience value.
     *
     * @return string
     */
    public function getConscience()
    {
        return $this->getWay('rai')->getScore() + $this->getWay('ide')->getScore();
    }

    /**
     * Get instinct value.
     *
     * @return string
     */
    public function getInstinct()
    {
        return $this->getWay('cre')->getScore() + $this->getWay('com')->getScore();
    }

    /**
     * Set jobCustom.
     *
     * @param string $jobCustom
     *
     * @return Characters
     */
    public function setJobCustom($jobCustom)
    {
        $this->jobCustom = $jobCustom;

        return $this;
    }

    /**
     * Get jobCustom.
     *
     * @return string
     */
    public function getJobCustom()
    {
        return $this->jobCustom;
    }

    /**
     * Set geoLiving.
     *
     * @param string $geoLiving
     *
     * @return Characters
     */
    public function setGeoLiving($geoLiving)
    {
        $this->geoLiving = $geoLiving;

        return $this;
    }

    /**
     * Get geoLiving.
     *
     * @return string
     */
    public function getGeoLiving()
    {
        return $this->geoLiving;
    }

    /**
     * Set trauma.
     *
     * @param int $trauma
     *
     * @return Characters
     */
    public function setTrauma($trauma)
    {
        $this->trauma = $trauma;

        return $this;
    }

    /**
     * Get trauma.
     *
     * @return int
     */
    public function getTrauma()
    {
        return $this->trauma;
    }

    /**
     * Set traumaPermanent.
     *
     * @param int $traumaPermanent
     *
     * @return Characters
     */
    public function setTraumaPermanent($traumaPermanent)
    {
        $this->traumaPermanent = $traumaPermanent;

        return $this;
    }

    /**
     * Get traumaPermanent.
     *
     * @return int
     */
    public function getTraumaPermanent()
    {
        return $this->traumaPermanent;
    }

    /**
     * Set age.
     *
     * @param int $age
     *
     * @return Characters
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age.
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set mentalResist.
     *
     * @param int $mentalResist
     *
     * @return Characters
     */
    public function setMentalResist($mentalResist)
    {
        $this->mentalResist = $mentalResist;

        return $this;
    }

    /**
     * Get mentalResist.
     *
     * @return int
     */
    public function getMentalResist()
    {
        return $this->mentalResist;
    }

    /**
     * Set health.
     *
     * @param int $health
     *
     * @return Characters
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get health.
     *
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set stamina.
     *
     * @param int $stamina
     *
     * @return Characters
     */
    public function setStamina($stamina)
    {
        $this->stamina = $stamina;

        return $this;
    }

    /**
     * Get stamina.
     *
     * @return int
     */
    public function getStamina()
    {
        return $this->stamina;
    }

    /**
     * Set survival.
     *
     * @param bool $survival
     *
     * @return Characters
     */
    public function setSurvival($survival)
    {
        $this->survival = $survival;

        return $this;
    }

    /**
     * Get survival.
     *
     * @return bool
     */
    public function getSurvival()
    {
        return $this->survival;
    }

    /**
     * Set speed.
     *
     * @param int $speed
     *
     * @return Characters
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed.
     *
     * @return int
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set defense.
     *
     * @param int $defense
     *
     * @return Characters
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * Get defense.
     *
     * @return int
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * Set rindath.
     *
     * @param int $rindath
     *
     * @return Characters
     */
    public function setRindath($rindath)
    {
        $this->rindath = $rindath;

        return $this;
    }

    /**
     * Get rindath.
     *
     * @return int
     */
    public function getRindath()
    {
        return $this->rindath;
    }

    /**
     * Set exaltation.
     *
     * @param int $exaltation
     *
     * @return Characters
     */
    public function setExaltation($exaltation)
    {
        $this->exaltation = $exaltation;

        return $this;
    }

    /**
     * Get exaltation.
     *
     * @return int
     */
    public function getExaltation()
    {
        return $this->exaltation;
    }

    /**
     * Set experienceActual.
     *
     * @param int $experienceActual
     *
     * @return Characters
     */
    public function setExperienceActual($experienceActual)
    {
        $this->experienceActual = $experienceActual;

        return $this;
    }

    /**
     * Get experienceActual.
     *
     * @return int
     */
    public function getExperienceActual()
    {
        return $this->experienceActual;
    }

    /**
     * Set experienceSpent.
     *
     * @param int $experienceSpent
     *
     * @return Characters
     */
    public function setExperienceSpent($experienceSpent)
    {
        $this->experienceSpent = $experienceSpent;

        return $this;
    }

    /**
     * Get experienceSpent.
     *
     * @return int
     */
    public function getExperienceSpent()
    {
        return $this->experienceSpent;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Characters
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
     * @return Characters
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
     * Set people.
     *
     * @param Peoples $people
     *
     * @return Characters
     */
    public function setPeople(Peoples $people = null)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people.
     *
     * @return Peoples
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Add armors.
     *
     * @param Armors $armors
     *
     * @return Characters
     */
    public function addArmor(Armors $armors)
    {
        $this->armors[] = $armors;

        return $this;
    }

    /**
     * Remove armors.
     *
     * @param Armors $armors
     */
    public function removeArmor(Armors $armors)
    {
        $this->armors->removeElement($armors);
    }

    /**
     * Get armors.
     *
     * @return Armors[]
     */
    public function getArmors()
    {
        return $this->armors;
    }

    /**
     * Add artifacts.
     *
     * @param Artifacts $artifacts
     *
     * @return Characters
     */
    public function addArtifact(Artifacts $artifacts)
    {
        $this->artifacts[] = $artifacts;

        return $this;
    }

    /**
     * Remove artifacts.
     *
     * @param Artifacts $artifacts
     */
    public function removeArtifact(Artifacts $artifacts)
    {
        $this->artifacts->removeElement($artifacts);
    }

    /**
     * Get artifacts.
     *
     * @return Artifacts[]
     */
    public function getArtifacts()
    {
        return $this->artifacts;
    }

    /**
     * Add miracles.
     *
     * @param Miracles $miracles
     *
     * @return Characters
     */
    public function addMiracle(Miracles $miracles)
    {
        $this->miracles[] = $miracles;

        return $this;
    }

    /**
     * Remove miracles.
     *
     * @param Miracles $miracles
     */
    public function removeMiracle(Miracles $miracles)
    {
        $this->miracles->removeElement($miracles);
    }

    /**
     * Get miracles.
     *
     * @return Miracles[]
     */
    public function getMiracles()
    {
        return $this->miracles;
    }

    /**
     * Add ogham.
     *
     * @param Ogham $ogham
     *
     * @return Characters
     */
    public function addOgham(Ogham $ogham)
    {
        $this->ogham[] = $ogham;

        return $this;
    }

    /**
     * Remove ogham.
     *
     * @param Ogham $ogham
     */
    public function removeOgham(Ogham $ogham)
    {
        $this->ogham->removeElement($ogham);
    }

    /**
     * Get ogham.
     *
     * @return Ogham[]
     */
    public function getOgham()
    {
        return $this->ogham;
    }

    /**
     * Add weapons.
     *
     * @param Weapons $weapons
     *
     * @return Characters
     */
    public function addWeapon(Weapons $weapons)
    {
        $this->weapons[] = $weapons;

        return $this;
    }

    /**
     * Remove weapons.
     *
     * @param Weapons $weapons
     */
    public function removeWeapon(Weapons $weapons)
    {
        $this->weapons->removeElement($weapons);
    }

    /**
     * Get weapons.
     *
     * @return Weapons[]
     */
    public function getWeapons()
    {
        return $this->weapons;
    }

    /**
     * Set socialClasses.
     *
     * @param SocialClasses $socialClasses
     *
     * @return Characters
     */
    public function setSocialClasses(SocialClasses $socialClasses = null)
    {
        $this->socialClasses = $socialClasses;

        return $this;
    }

    /**
     * Get socialClasses.
     *
     * @return SocialClasses
     */
    public function getSocialClasses()
    {
        return $this->socialClasses;
    }

    /**
     * Set SocialClassDomain1.
     *
     * @param Domains $socialClassDomain1
     *
     * @return Characters
     */
    public function setSocialClassDomain1(Domains $socialClassDomain1 = null)
    {
        $this->SocialClassDomain1 = $socialClassDomain1;

        return $this;
    }

    /**
     * Get SocialClassDomain1.
     *
     * @return Domains
     */
    public function getSocialClassDomain1()
    {
        return $this->SocialClassDomain1;
    }

    /**
     * Set SocialClassDomain2.
     *
     * @param Domains $socialClassDomain2
     *
     * @return Characters
     */
    public function setSocialClassDomain2(Domains $socialClassDomain2 = null)
    {
        $this->SocialClassDomain2 = $socialClassDomain2;

        return $this;
    }

    /**
     * Get SocialClassDomain2.
     *
     * @return Domains
     */
    public function getSocialClassDomain2()
    {
        return $this->SocialClassDomain2;
    }

    /**
     * Set disorder.
     *
     * @param Disorders $disorder
     *
     * @return Characters
     */
    public function setDisorder(Disorders $disorder = null)
    {
        $this->disorder = $disorder;

        return $this;
    }

    /**
     * Get disorder.
     *
     * @return Disorders
     */
    public function getDisorder()
    {
        return $this->disorder;
    }

    /**
     * Set job.
     *
     * @param Jobs $job
     *
     * @return Characters
     */
    public function setJob(Jobs $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job.
     *
     * @return Jobs
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set region.
     *
     * @param Regions $region
     *
     * @return Characters
     */
    public function setRegion(Regions $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region.
     *
     * @return Regions
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set traitFlaw.
     *
     * @param Traits $traitFlaw
     *
     * @return Characters
     */
    public function setTraitFlaw(Traits $traitFlaw = null)
    {
        $this->traitFlaw = $traitFlaw;

        return $this;
    }

    /**
     * Get traitFlaw.
     *
     * @return Traits
     */
    public function getTraitFlaw()
    {
        return $this->traitFlaw;
    }

    /**
     * Set traitQuality.
     *
     * @param Traits $traitQuality
     *
     * @return Characters
     */
    public function setTraitQuality(Traits $traitQuality = null)
    {
        $this->traitQuality = $traitQuality;

        return $this;
    }

    /**
     * Get traitQuality.
     *
     * @return Traits
     */
    public function getTraitQuality()
    {
        return $this->traitQuality;
    }

    /**
     * Add avantages.
     *
     * @param CharAvtgs $avantages
     *
     * @return Characters
     */
    public function addAvantage(CharAvtgs $avantages)
    {
        $this->avantages[] = $avantages;

        return $this;
    }

    /**
     * Remove avantages.
     *
     * @param CharAvtgs $avantages
     */
    public function removeAvantage(CharAvtgs $avantages)
    {
        $this->avantages->removeElement($avantages);
    }

    /**
     * Get avantages.
     *
     * @return Avantages[]
     */
    public function getAvantages()
    {
        return $this->avantages;
    }

    /**
     * Add domains.
     *
     * @param CharDomains $domains
     *
     * @return Characters
     */
    public function addDomain(CharDomains $domains)
    {
        $this->domains[] = $domains;

        return $this;
    }

    /**
     * Remove domains.
     *
     * @param CharDomains $domains
     */
    public function removeDomain(CharDomains $domains)
    {
        $this->domains->removeElement($domains);
    }

    /**
     * Get domains.
     *
     * @return Domains[]
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * Add disciplines.
     *
     * @param CharDisciplines $disciplines
     *
     * @return Characters
     */
    public function addDiscipline(CharDisciplines $disciplines)
    {
        $this->disciplines[] = $disciplines;

        return $this;
    }

    /**
     * Remove disciplines.
     *
     * @param CharDisciplines $disciplines
     */
    public function removeDiscipline(CharDisciplines $disciplines)
    {
        $this->disciplines->removeElement($disciplines);
    }

    /**
     * Get disciplines.
     *
     * @return Disciplines[]
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    /**
     * Add ways.
     *
     * @param CharWays $ways
     *
     * @return Characters
     */
    public function addWay(CharWays $ways)
    {
        $this->ways[] = $ways;

        return $this;
    }

    /**
     * Remove ways.
     *
     * @param CharWays $ways
     */
    public function removeWay(CharWays $ways)
    {
        $this->ways->removeElement($ways);
    }

    /**
     * Get ways.
     *
     * @return Ways[]
     */
    public function getWays()
    {
        return $this->ways;
    }

    /**
     * Add flux.
     *
     * @param CharFlux $flux
     *
     * @return Characters
     */
    public function addFlux(CharFlux $flux)
    {
        $this->flux[] = $flux;

        return $this;
    }

    /**
     * Remove flux.
     *
     * @param CharFlux $flux
     */
    public function removeFlux(CharFlux $flux)
    {
        $this->flux->removeElement($flux);
    }

    /**
     * Get flux.
     *
     * @return Flux[]
     */
    public function getFlux()
    {
        return $this->flux;
    }

    /**
     * Add CharModifications[].
     *
     * @param CharModifications $modifications
     *
     * @return Characters
     */
    public function addModification(CharModifications $modifications)
    {
        $this->modifications[] = $modifications;

        return $this;
    }

    /**
     * Remove modifications.
     *
     * @param CharModifications $modifications
     */
    public function removeModification(CharModifications $modifications)
    {
        $this->modifications->removeElement($modifications);
    }

    /**
     * Get modifications.
     *
     * @return array
     */
    public function getModifications()
    {
        return $this->modifications;
    }

    /**
     * Add setbacks.
     *
     * @param CharSetbacks $setbacks
     *
     * @return Characters
     */
    public function addSetback(CharSetbacks $setbacks)
    {
        $this->setbacks[] = $setbacks;

        return $this;
    }

    /**
     * Remove setbacks.
     *
     * @param CharSetbacks $setbacks
     */
    public function removeSetback(CharSetbacks $setbacks)
    {
        $this->setbacks->removeElement($setbacks);
    }

    /**
     * Get setbacks.
     *
     * @return Setbacks[]
     */
    public function getSetbacks()
    {
        return $this->setbacks;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Characters
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set game.
     *
     * @param Games $game
     *
     * @return Characters
     */
    public function setGame(Games $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game.
     *
     * @return Games
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set hardening.
     *
     * @param int $hardening
     *
     * @return Characters
     */
    public function setHardening($hardening)
    {
        $this->hardening = $hardening;

        return $this;
    }

    /**
     * Get hardening.
     *
     * @return int
     */
    public function getHardening()
    {
        return $this->hardening;
    }

    /*-------------------------------------------------*/
    /*-------------------------------------------------*/
    /*-------Méthodes de récupération de données-------*/
    /*-------------------------------------------------*/
    /*-------------------------------------------------*/

    /**
     * Get domain.
     *
     * @param int $id
     *
     * @return CharDomains
     */
    public function getDomain($id)
    {
        foreach ($this->domains as $charDomain) {
            if (
                $charDomain instanceof CharDomains &&
                ($charDomain->getDomain()->getId() == $id
                    || $charDomain->getDomain()->getName() == $id
                    || $charDomain->getDomain() === $id
                )
            ) {
                return $charDomain;
            }
        }

        return;
    }

    /**
     * Get way.
     *
     * @param string $shortName
     *
     * @return CharWays|null
     */
    public function getWay($shortName)
    {
        foreach ($this->ways as $charWay) {
            if (
                $charWay instanceof CharWays &&
                $charWay->getWay()->getShortName() == $shortName
            ) {
                return $charWay;
            }
        }

        return;
    }

    /**
     * Get discipline.
     *
     * @param mixed $id La discipline à chercher. Peut être son ID, son nom ou l'objet lui-même.
     *
     * @return CharDisciplines|null
     */
    public function getDiscipline($id)
    {
        foreach ($this->disciplines as $charDiscipline) {
            if (
                $charDiscipline instanceof CharDisciplines &&
                ($charDiscipline->getDiscipline()->getId() == $id
                    || $charDiscipline->getDiscipline()->getName() == $id
                    || $charDiscipline->getDiscipline() == $id)
            ) {
                return $charDiscipline;
            }
        }

        return;
    }

    /**
     * Retourne le score de base de défense du personnage.
     *
     * @return int
     */
    public function getBaseDefense()
    {
        $rai = $this->getWay('rai')->getScore();
        $emp = $this->getWay('emp')->getScore();

        return $rai + $emp + 5;
    }

    /**
     * Retourne le score de base de rapidité du personnage.
     *
     * @return int
     */
    public function getBaseSpeed()
    {
        $com = $this->getWay('com')->getScore();
        $emp = $this->getWay('emp')->getScore();

        return $com + $emp;
    }

    /**
     * Retourne le score de base de rapidité du personnage.
     *
     * @return int
     */
    public function getBaseMentalResist()
    {
        $ide = $this->getWay('ide')->getScore();

        return $ide + 5;
    }

    public function getPotential()
    {
        $creativity = $this->getWay('cre')->getScore();
        if ($creativity == 1) {
            return 1;
        } elseif ($creativity >= 2 && $creativity <= 4) {
            return 2;
        } elseif ($creativity == 5) {
            return 3;
        } else {
            throw new CharactersException('Le calcul du potentiel du personnage a renvoyé une erreur');
        }
    }

    /**
     * Retourne le score de base de combat au contact.
     *
     * @param null   $discipline
     * @param string $potential
     *
     * @return int
     */
    public function getMeleeAttackScore($discipline = null, $potential = '')
    {
        return $this->getAttackScore('melee', $discipline, $potential);
    }

    /**
     * Retourne le score de base du type de combat spécifié dans $type.
     * Si $discipline est mentionné, il doit s'agir d'un identifiant valide de discipline,.
     *
     * @param string $type
     * @param null   $discipline
     * @param string $potential
     *
     * @throws CharactersException
     *
     * @return int
     */
    public function getAttackScore($type = 'melee', $discipline = null, $potential = '')
    {

        // Récupération du score de voie
        $way = $this->getWay('com')->getScore();

        // Définition de l'id des domaines "Combat au contact" et "Tir & lancer"
        if ($type === 'melee') {
            $domain_id = 2;
        } elseif ($type === 'ranged') {
            $domain_id = 14;
        } else {
            throw new CharactersException('Vous devez indiquer un type d\'attaque entre "melee" et "ranged".');
        }

        // Récupération du score du domaine
        $domain = $this->getDomain($domain_id)->getScore();

        // Si on indique une discipline, le score du domaine sera remplacé par le score de discipline
        if ($discipline) {
            $discipline = $this->getDiscipline($discipline);

            // Il faut impérativement que la discipline soit associée au même domaine
            if ($discipline->getDomain()->getId() == $domain_id) {
                // Remplacement du nouveau score
                $domain = $discipline->getScore();
            }
        }

        $attack = $way + $domain;

        if ($potential == '+') {
            $attack += $this->getPotential();
        } elseif ($potential === '-') {
            $attack -= $this->getPotential();
        }

        return $attack;
    }

    /**
     * Set maxHealth.
     *
     * @param int $maxHealth
     *
     * @return Characters
     */
    public function setMaxHealth($maxHealth)
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }

    /**
     * Get maxHealth.
     *
     * @return int
     */
    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return Characters
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

<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharAdvantages;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDisciplines;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDomains;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharFlux;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharSetbacks;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharWays;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\Money;
use Doctrine\Common\Collections\Collection;
use Pierstoval\Bundle\CharacterManagerBundle\Model\Character as BaseCharacter;
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
class Characters extends BaseCharacter
{
    const FEMALE = 'character.sex.female';
    const MALE = 'character.sex.male';

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
     * @var Money
     *
     * @ORM\Embedded(class="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\Money", columnPrefix="daol_")
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
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Peoples")
     */
    protected $people;

    /**
     * @var Armors[]
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Armors")
     */
    protected $armors;

    /**
     * @var Artifacts[]
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Artifacts")
     */
    protected $artifacts;

    /**
     * @var Miracles[]
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Miracles")
     */
    protected $miracles;

    /**
     * @var Ogham[]
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Ogham")
     */
    protected $ogham;

    /**
     * @var Weapons[]
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Weapons")
     */
    protected $weapons;

    /**
     * @var SocialClasses
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\SocialClasses", fetch="EAGER")
     */
    protected $socialClasses;

    /**
     * @var Domains
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Domains")
     */
    protected $socialClassDomain1;

    /**
     * @var Domains
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Domains")
     */
    protected $socialClassDomain2;

    /**
     * @var Disorders
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Disorders")
     */
    protected $disorder;

    /**
     * @var Jobs
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Jobs", fetch="EAGER")
     */
    protected $job;

    /**
     * @var Regions
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Regions", fetch="EAGER")
     */
    protected $region;

    /**
     * @var Traits
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Traits")
     * @ORM\JoinColumn(name="trait_flaw_id")
     */
    protected $flaw;

    /**
     * @var Traits
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Traits")
     * @ORM\JoinColumn(name="trait_quality_id")
     */
    protected $quality;

    /**
     * @var CharAdvantages[]
     *
     * @ORM\OneToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharAdvantages", mappedBy="character")
     */
    protected $advantages;

    /**
     * @var CharDomains[]
     *
     * @ORM\OneToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDomains", mappedBy="character")
     */
    protected $domains;

    /**
     * @var CharDisciplines[]
     *
     * @ORM\OneToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDisciplines", mappedBy="character")
     */
    protected $disciplines;

    /**
     * @var CharWays[]
     *
     * @ORM\OneToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharWays", mappedBy="character")
     */
    protected $ways;

    /**
     * @var CharFlux[]
     *
     * @ORM\OneToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharFlux", mappedBy="character")
     */
    protected $flux;

    /**
     * @var CharSetbacks[]
     *
     * @ORM\OneToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharSetbacks", mappedBy="character")
     */
    protected $setbacks;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", fetch="EAGER")
     */
    protected $user;

    /**
     * @var Games
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Games", inversedBy="characters", fetch="EAGER")
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
    protected $deleted;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->armors      = new ArrayCollection();
        $this->artifacts   = new ArrayCollection();
        $this->miracles    = new ArrayCollection();
        $this->ogham       = new ArrayCollection();
        $this->weapons     = new ArrayCollection();
        $this->advantages  = new ArrayCollection();
        $this->domains     = new ArrayCollection();
        $this->disciplines = new ArrayCollection();
        $this->ways        = new ArrayCollection();
        $this->flux        = new ArrayCollection();
        $this->setbacks    = new ArrayCollection();
    }

    /*-------------------------------------------------*/
    /*-------------------------------------------------*/
    /*----------- Plain getters and setters -----------*/
    /*-------------------------------------------------*/
    /*-------------------------------------------------*/

    /**
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
     * @return string
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
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
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
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
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
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
     * @return string
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
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
     * @return string
     */
    public function getFacts()
    {
        return $this->facts;
    }

    /**
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
     * @return array
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * @param Money $money
     *
     * @return Characters
     */
    public function setMoney(Money $money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * @return Money
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
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
     * @return string
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
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
     * @return string
     */
    public function getJobCustom()
    {
        return $this->jobCustom;
    }

    /**
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
     * @return string
     */
    public function getGeoLiving()
    {
        return $this->geoLiving;
    }

    /**
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
     * @return int
     */
    public function getTrauma()
    {
        return $this->trauma;
    }

    /**
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
     * @return int
     */
    public function getTraumaPermanent()
    {
        return $this->traumaPermanent;
    }

    /**
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
     * @return int
     */
    public function getHardening()
    {
        return $this->hardening;
    }

    /**
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
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
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
     * @return int
     */
    public function getMentalResist()
    {
        return $this->mentalResist;
    }

    /**
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
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
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
     * @return int
     */
    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    /**
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
     * @return int
     */
    public function getStamina()
    {
        return $this->stamina;
    }

    /**
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
     * @return bool
     */
    public function getSurvival()
    {
        return $this->survival;
    }

    /**
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
     * @return int
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
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
     * @return int
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
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
     * @return int
     */
    public function getRindath()
    {
        return $this->rindath;
    }

    /**
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
     * @return int
     */
    public function getExaltation()
    {
        return $this->exaltation;
    }

    /**
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
     * @return int
     */
    public function getExperienceActual()
    {
        return $this->experienceActual;
    }

    /**
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
     * @return int
     */
    public function getExperienceSpent()
    {
        return $this->experienceSpent;
    }

    /**
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
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
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
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $deleted
     *
     * @return Characters
     */
    public function setDeleted(\DateTime $deleted = null)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
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
     * @return Peoples
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * @param Armors $armor
     *
     * @return Characters
     */
    public function addArmor(Armors $armor)
    {
        $this->armors[] = $armor;

        return $this;
    }

    /**
     * @param Armors $armor
     *
     * @return Characters
     */
    public function removeArmor(Armors $armor)
    {
        $this->armors->removeElement($armor);

        return $this;
    }

    /**
     * @return Armors[]
     */
    public function getArmors()
    {
        return $this->armors;
    }

    /**
     * @param Artifacts $artifact
     *
     * @return Characters
     */
    public function addArtifact(Artifacts $artifact)
    {
        $this->artifacts[] = $artifact;

        return $this;
    }

    /**
     * @param Artifacts $artifact
     *
     * @return Characters
     */
    public function removeArtifact(Artifacts $artifact)
    {
        $this->artifacts->removeElement($artifact);

        return $this;
    }

    /**
     * @return Artifacts[]
     */
    public function getArtifacts()
    {
        return $this->artifacts;
    }

    /**
     * @param Miracles $miracle
     *
     * @return Characters
     */
    public function addMiracle(Miracles $miracle)
    {
        $this->miracles[] = $miracle;

        return $this;
    }

    /**
     * @param Miracles $miracle
     *
     * @return Characters
     */
    public function removeMiracle(Miracles $miracle)
    {
        $this->miracles->removeElement($miracle);

        return $this;
    }

    /**
     * @return Miracles[]
     */
    public function getMiracles()
    {
        return $this->miracles;
    }

    /**
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
     * @param Ogham $ogham
     *
     * @return Characters
     */
    public function removeOgham(Ogham $ogham)
    {
        $this->ogham->removeElement($ogham);

        return $this;
    }

    /**
     * @return Ogham[]
     */
    public function getOgham()
    {
        return $this->ogham;
    }

    /**
     * @param Weapons $weapon
     *
     * @return Characters
     */
    public function addWeapon(Weapons $weapon)
    {
        $this->weapons[] = $weapon;

        return $this;
    }

    /**
     * @param Weapons $weapon
     *
     * @return Characters
     */
    public function removeWeapon(Weapons $weapon)
    {
        $this->weapons->removeElement($weapon);

        return $this;
    }

    /**
     * @return Weapons[]
     */
    public function getWeapons()
    {
        return $this->weapons;
    }

    /**
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
     * @return SocialClasses
     */
    public function getSocialClasses()
    {
        return $this->socialClasses;
    }

    /**
     * @param Domains $socialClassDomain1
     *
     * @return Characters
     */
    public function setSocialClassDomain1(Domains $socialClassDomain1 = null)
    {
        $this->socialClassDomain1 = $socialClassDomain1;

        return $this;
    }

    /**
     * @return Domains
     */
    public function getSocialClassDomain1()
    {
        return $this->socialClassDomain1;
    }

    /**
     * @param Domains $socialClassDomain2
     *
     * @return Characters
     */
    public function setSocialClassDomain2(Domains $socialClassDomain2 = null)
    {
        $this->socialClassDomain2 = $socialClassDomain2;

        return $this;
    }

    /**
     * @return Domains
     */
    public function getSocialClassDomain2()
    {
        return $this->socialClassDomain2;
    }

    /**
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
     * @return Disorders
     */
    public function getDisorder()
    {
        return $this->disorder;
    }

    /**
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
     * @return Jobs
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
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
     * @return Regions
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param Traits $flaw
     *
     * @return Characters
     */
    public function setFlaw(Traits $flaw = null)
    {
        $this->flaw = $flaw;

        return $this;
    }

    /**
     * @return Traits
     */
    public function getFlaw()
    {
        return $this->flaw;
    }

    /**
     * @param Traits $quality
     *
     * @return Characters
     */
    public function setQuality(Traits $quality = null)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * @return Traits
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param CharAdvantages $advantage
     *
     * @return Characters
     */
    public function addAdvantage(CharAdvantages $advantage)
    {
        $this->advantages[] = $advantage;

        return $this;
    }

    /**
     * @param CharAdvantages $advantage
     *
     * @return Characters
     */
    public function removeAdvantage(CharAdvantages $advantage)
    {
        $this->advantages->removeElement($advantage);

        return $this;
    }

    /**
     * @return CharAdvantages[]
     */
    public function getAdvantages()
    {
        return $this->advantages;
    }

    /**
     * @param CharDomains $domain
     *
     * @return Characters
     */
    public function addDomain(CharDomains $domain)
    {
        $this->domains[] = $domain;

        return $this;
    }

    /**
     * @param CharDomains $domain
     *
     * @return $this
     */
    public function removeDomain(CharDomains $domain)
    {
        $this->domains->removeElement($domain);

        return $this;
    }

    /**
     * @return CharDomains[]
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * @param CharDisciplines $discipline
     *
     * @return Characters
     */
    public function addDiscipline(CharDisciplines $discipline)
    {
        $this->disciplines[] = $discipline;

        return $this;
    }

    /**
     * @param CharDisciplines $discipline
     *
     * @return $this
     */
    public function removeDiscipline(CharDisciplines $discipline)
    {
        $this->disciplines->removeElement($discipline);

        return $this;
    }

    /**
     * @return CharDisciplines[]
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    /**
     * @param CharWays $way
     *
     * @return Characters
     */
    public function addWay(CharWays $way)
    {
        $this->ways[] = $way;

        return $this;
    }

    /**
     * @param CharWays $way
     *
     * @return $this
     */
    public function removeWay(CharWays $way)
    {
        $this->ways->removeElement($way);

        return $this;
    }

    /**
     * @return CharWays[]|Collection
     */
    public function getWays()
    {
        return $this->ways;
    }

    /**
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
     * @param CharFlux $flux
     *
     * @return $this
     */
    public function removeFlux(CharFlux $flux)
    {
        $this->flux->removeElement($flux);

        return $this;
    }

    /**
     * @return CharFlux[]
     */
    public function getFlux()
    {
        return $this->flux;
    }

    /**
     * @param CharSetbacks $setback
     *
     * @return Characters
     */
    public function addSetback(CharSetbacks $setback)
    {
        $this->setbacks[] = $setback;

        return $this;
    }

    /**
     * @param CharSetbacks $setback
     *
     * @return $this
     */
    public function removeSetback(CharSetbacks $setback)
    {
        $this->setbacks->removeElement($setback);

        return $this;
    }

    /**
     * @return CharSetbacks[]|ArrayCollection
     */
    public function getSetbacks()
    {
        return $this->setbacks;
    }

    /**
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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
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
     * @return Games
     */
    public function getGame()
    {
        return $this->game;
    }

    /*-------------------------------------------------*/
    /*-------------------------------------------------*/
    /*--------- Methods used for entity logic ---------*/
    /*-------------------------------------------------*/
    /*-------------------------------------------------*/

    public function createFromGenerator(array $data) {
        $character = new static();

        $mandatoryFields = [
            'name',
        ];

        foreach ($mandatoryFields as $field) {
            if (!array_key_exists($field, $data)) {
                throw new \InvalidArgumentException('Field "'.$field.'" is not defined in data.');
            }
            $this->$field = $data[$field];
        }

        //TODO: add logic

        return $character;
    }

    /**
     * Conscience is determined by "Reason" and "Conviction" ways.
     *
     * @return string
     */
    public function getConscience()
    {
        return $this->getWay('rai')->getScore() + $this->getWay('ide')->getScore();
    }

    /**
     * Conscience is determined by "Creativity" and "Combativity" ways.
     *
     * @return string
     */
    public function getInstinct()
    {
        return $this->getWay('cre')->getScore() + $this->getWay('com')->getScore();
    }

    /**
     * Get a domain based on its id or name.
     *
     * @param int|string $id
     *
     * @return CharDomains
     */
    public function getDomain($id)
    {
        foreach ($this->domains as $charDomain) {
            $domain = $charDomain->getDomain();
            if (
                $charDomain instanceof CharDomains &&
                (($domain->getId() === (int) $id) || $domain->getName() === $id)
            ) {
                return $charDomain;
            }
        }

        return null;
    }

    /**
     * @param string $shortName
     *
     * @return CharWays|null
     */
    public function getWay($shortName)
    {
        foreach ($this->ways as $charWay) {
            if (
                $charWay instanceof CharWays &&
                $charWay->getWay()->getShortName() === $shortName
            ) {
                return $charWay;
            }
        }

        return null;
    }

    /**
     * @param int|string $id
     *
     * @return CharDisciplines|null
     */
    public function getDiscipline($id)
    {
        foreach ($this->disciplines as $charDiscipline) {
            $discipline = $charDiscipline->getDiscipline();
            if (
                $charDiscipline instanceof CharDisciplines &&
                (($discipline->getId() === (int) $id) || $discipline->getName() === $id)
            ) {
                return $charDiscipline;
            }
        }

        return null;
    }

    /**
     * Base defense is calculated from "Reason" and "Empathy".
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
     * Base speed is calculated from "Combativity" and "Empathy".
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
     * Base mental resistance is calculated from "Conviction".
     *
     * @return int
     */
    public function getBaseMentalResist()
    {
        $ide = $this->getWay('ide')->getScore();

        return $ide + 5;
    }

    /**
     * @return int
     * @throws CharactersException
     */
    public function getPotential()
    {
        $creativity = (int) $this->getWay('cre')->getScore();
        if ($creativity === 1) {
            return 1;
        } elseif ($creativity >= 2 && $creativity <= 4) {
            return 2;
        } elseif ($creativity === 5) {
            return 3;
        } else {
            throw new CharactersException('Le calcul du potentiel du personnage a renvoyé une erreur');
        }
    }

    /**
     * Calculate melee attack score.
     *
     * @param int|string $discipline
     * @param string     $potentialOperator  Can be "+" or "-"
     *
     * @return int
     */
    public function getMeleeAttackScore($discipline = null, $potentialOperator = '')
    {
        return $this->getAttackScore('melee', $discipline, $potentialOperator);
    }

    /**
     * Retourne le score de base du type de combat spécifié dans $type.
     * Si $discipline est mentionné, il doit s'agir d'un identifiant valide de discipline,.
     *
     * @param string     $type
     * @param int|string $discipline
     * @param string     $potentialOperator Can be "+" or "-".
     *
     * @throws CharactersException
     *
     * @return int
     */
    public function getAttackScore($type = 'melee', $discipline = null, $potentialOperator = '')
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

        $domain_id = (int)$domain_id;

        // Récupération du score du domaine
        $domain = $this->getDomain($domain_id)->getScore();

        // Si on indique une discipline, le score du domaine sera remplacé par le score de discipline
        if (null !== $discipline) {
            $charDiscipline = $this->getDiscipline($discipline);

            // Il faut impérativement que la discipline soit associée au même domaine
            if ($charDiscipline->getDomain()->getId() === $domain_id) {
                // Remplacement du nouveau score
                $domain = $charDiscipline->getScore();
            }
        }

        $attack = $way + $domain;

        if ($potentialOperator === '+') {
            $attack += $this->getPotential();
        } elseif ($potentialOperator === '-') {
            $attack -= $this->getPotential();
        } else {
            throw new \InvalidArgumentException(sprintf(
                'Wrong potential operator specified: "%s" or "%s" expected, "%s" given.',
                '+', '-', $potentialOperator
            ));
        }

        return $attack;
    }

}

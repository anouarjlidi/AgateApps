<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CorahnRin\CharactersBundle\Exceptions\CharactersException as Exception;

/**
 * Characters
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharactersRepository")
 * @ORM\Table(name="characters",uniqueConstraints={@ORM\UniqueConstraint(name="idcUnique", columns={"name", "user_id"})})
 */
class Characters
{
    /**
     * @var integer
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
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Gedmo\Mapping\Annotation\Slug(fields={"name"},unique=false)
     */
    protected $nameSlug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $playerName;

    /**
     * @var integer
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
     * @var CorahnRin\CharactersBundle\Classes\Money
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
     * @var Peoples
     *
     * @ORM\ManyToOne(targetEntity="Peoples")
     */
    protected $people;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     */
    protected $geoLiving;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", options={"default":0})
     */
    protected $trauma;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", options={"default":0})
     */
    protected $traumaPermanent;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", options={"default":0})
     */
    protected $hardening;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $age;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $mentalResist;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", options={"default":0})
     */
    protected $mentalResistExp;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $health;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $stamina;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $survival;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $speed;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint",options={"default":0})
     */
    protected $speedExp;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $defense;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint",options={"default":0})
     */
    protected $defenseExp;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $rindath;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $exaltation;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $experienceActual;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $experienceSpent;

    /**
     * @var \Datetime
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime

     * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Armors")
     */
    protected $armors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Artifacts")
     */
    protected $artifacts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Miracles")
     */
    protected $miracles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ogham")
     */
    protected $ogham;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Weapons")
     */
    protected $weapons;

    /**
     * @var \SocialClasses
     *
     * @ORM\ManyToOne(targetEntity="SocialClasses")
     */
    protected $socialClasses;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    protected $SocialClassDomain1;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    protected $SocialClassDomain2;

    /**
     * @var \Disorders
     *
     * @ORM\ManyToOne(targetEntity="Disorders")
     */
    protected $disorder;

    /**
     * @var \Jobs
     *
     * @ORM\ManyToOne(targetEntity="Jobs")
     */
    protected $job;

    /**
     * @var \Regions
     *
     * @ORM\ManyToOne(targetEntity="Regions")
     */
    protected $region;

    /**
     * @var \Traits
     * @ORM\ManyToOne(targetEntity="Traits")
     */
    protected $traitFlaw;

    /**
     * @var \Traits
     * @ORM\ManyToOne(targetEntity="Traits")
     */
    protected $traitQuality;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharAvtgs", mappedBy="character")
     */
    protected $avantages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharDomains", mappedBy="character")
     */
    protected $domains;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharDisciplines", mappedBy="character")
     */
    protected $disciplines;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharWays", mappedBy="character")
     */
    protected $ways;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharFlux", mappedBy="character")
     */
    protected $flux;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharModifications", mappedBy="character")
     */
    protected $modifications;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharSetbacks", mappedBy="character")
     */
    protected $setbacks;

    /**
     * @var \Users
     * @ORM\ManyToOne(targetEntity="CorahnRin\UsersBundle\Entity\Users", inversedBy="characters")
     */
    protected $user;

	/**
	 * @var \Games
	 * @ORM\ManyToOne(targetEntity="Games", inversedBy="characters")
	 */
	protected $game;

	protected $baseChar;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
     */
    protected $deleted;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->armors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->artifacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->miracles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ogham = new \Doctrine\Common\Collections\ArrayCollection();
        $this->weapons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->avantages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->domains = new \Doctrine\Common\Collections\ArrayCollection();
        $this->disciplines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ways = new \Doctrine\Common\Collections\ArrayCollection();
        $this->flux = new \Doctrine\Common\Collections\ArrayCollection();
        $this->modifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setbacks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Characters
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameSlug
     *
     * @param string $nameSlug
     * @return Characters
     */
    public function setNameSlug($nameSlug)
    {
        $this->nameSlug = $nameSlug;

        return $this;
    }

    /**
     * Get nameSlug
     *
     * @return string
     */
    public function getNameSlug()
    {
        return $this->nameSlug;
    }

    /**
     * Set playerName
     *
     * @param string $playerName
     * @return Characters
     */
    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;

        return $this;
    }

    /**
     * Get playerName
     *
     * @return string
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Characters
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return Characters
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Characters
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set story
     *
     * @param string $story
     * @return Characters
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return string
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set facts
     *
     * @param string $facts
     * @return Characters
     */
    public function setFacts($facts)
    {
        $this->facts = $facts;

        return $this;
    }

    /**
     * Get facts
     *
     * @return string
     */
    public function getFacts()
    {
        return $this->facts;
    }

    /**
     * Set inventory
     *
     * @param array $inventory
     * @return Characters
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory
     *
     * @return array
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set money
     *
     * @param \CorahnRin\CharactersBundle\Classes\Money $money
     * @return Characters
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return CorahnRin\CharactersBundle\Classes\Money
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set orientation
     *
     * @param string $orientation
     * @return Characters
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation
     *
     * @return string
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Get conscience value
     *
     * @return string
     */
    public function getConscience()
    {
        return $this->getWay('rai')->getScore() + $this->getWay('ide')->getScore();
    }

    /**
     * Get instinct value
     *
     * @return string
     */
    public function getInstinct()
    {
        return $this->getWay('cre')->getScore() + $this->getWay('com')->getScore();
    }

    /**
     * Set jobCustom
     *
     * @param string $jobCustom
     * @return Characters
     */
    public function setJobCustom($jobCustom)
    {
        $this->jobCustom = $jobCustom;

        return $this;
    }

    /**
     * Get jobCustom
     *
     * @return string
     */
    public function getJobCustom()
    {
        return $this->jobCustom;
    }

    /**
     * Set geoLiving
     *
     * @param string $geoLiving
     * @return Characters
     */
    public function setGeoLiving($geoLiving)
    {
        $this->geoLiving = $geoLiving;

        return $this;
    }

    /**
     * Get geoLiving
     *
     * @return string
     */
    public function getGeoLiving()
    {
        return $this->geoLiving;
    }

    /**
     * Set trauma
     *
     * @param integer $trauma
     * @return Characters
     */
    public function setTrauma($trauma)
    {
        $this->trauma = $trauma;

        return $this;
    }

    /**
     * Get trauma
     *
     * @return integer
     */
    public function getTrauma()
    {
        return $this->trauma;
    }

    /**
     * Set traumaPermanent
     *
     * @param integer $traumaPermanent
     * @return Characters
     */
    public function setTraumaPermanent($traumaPermanent)
    {
        $this->traumaPermanent = $traumaPermanent;

        return $this;
    }

    /**
     * Get traumaPermanent
     *
     * @return integer
     */
    public function getTraumaPermanent()
    {
        return $this->traumaPermanent;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Characters
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set mentalResist
     *
     * @param integer $mentalResist
     * @return Characters
     */
    public function setMentalResist($mentalResist)
    {
        $this->mentalResist = $mentalResist;

        return $this;
    }

    /**
     * Get mentalResist
     *
     * @return integer
     */
    public function getMentalResist()
    {
        return $this->mentalResist;
    }

    /**
     * Set health
     *
     * @param integer $health
     * @return Characters
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get health
     *
     * @return integer
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set stamina
     *
     * @param integer $stamina
     * @return Characters
     */
    public function setStamina($stamina)
    {
        $this->stamina = $stamina;

        return $this;
    }

    /**
     * Get stamina
     *
     * @return integer
     */
    public function getStamina()
    {
        return $this->stamina;
    }

    /**
     * Set survival
     *
     * @param boolean $survival
     * @return Characters
     */
    public function setSurvival($survival)
    {
        $this->survival = $survival;

        return $this;
    }

    /**
     * Get survival
     *
     * @return boolean
     */
    public function getSurvival()
    {
        return $this->survival;
    }

    /**
     * Set speed
     *
     * @param integer $speed
     * @return Characters
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return integer
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set defense
     *
     * @param integer $defense
     * @return Characters
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * Get defense
     *
     * @return integer
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * Set rindath
     *
     * @param integer $rindath
     * @return Characters
     */
    public function setRindath($rindath)
    {
        $this->rindath = $rindath;

        return $this;
    }

    /**
     * Get rindath
     *
     * @return integer
     */
    public function getRindath()
    {
        return $this->rindath;
    }

    /**
     * Set exaltation
     *
     * @param integer $exaltation
     * @return Characters
     */
    public function setExaltation($exaltation)
    {
        $this->exaltation = $exaltation;

        return $this;
    }

    /**
     * Get exaltation
     *
     * @return integer
     */
    public function getExaltation()
    {
        return $this->exaltation;
    }

    /**
     * Set experienceActual
     *
     * @param integer $experienceActual
     * @return Characters
     */
    public function setExperienceActual($experienceActual)
    {
        $this->experienceActual = $experienceActual;

        return $this;
    }

    /**
     * Get experienceActual
     *
     * @return integer
     */
    public function getExperienceActual()
    {
        return $this->experienceActual;
    }

    /**
     * Set experienceSpent
     *
     * @param integer $experienceSpent
     * @return Characters
     */
    public function setExperienceSpent($experienceSpent)
    {
        $this->experienceSpent = $experienceSpent;

        return $this;
    }

    /**
     * Get experienceSpent
     *
     * @return integer
     */
    public function getExperienceSpent()
    {
        return $this->experienceSpent;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Characters
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Characters
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Characters
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set people
     *
     * @param \CorahnRin\CharactersBundle\Entity\Peoples $people
     * @return Characters
     */
    public function setPeople(\CorahnRin\CharactersBundle\Entity\Peoples $people = null)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people
     *
     * @return \CorahnRin\CharactersBundle\Entity\Peoples
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Add armors
     *
     * @param \CorahnRin\CharactersBundle\Entity\Armors $armors
     * @return Characters
     */
    public function addArmor(\CorahnRin\CharactersBundle\Entity\Armors $armors)
    {
        $this->armors[] = $armors;

        return $this;
    }

    /**
     * Remove armors
     *
     * @param \CorahnRin\CharactersBundle\Entity\Armors $armors
     */
    public function removeArmor(\CorahnRin\CharactersBundle\Entity\Armors $armors)
    {
        $this->armors->removeElement($armors);
    }

    /**
     * Get armors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArmors()
    {
        return $this->armors;
    }

    /**
     * Add artifacts
     *
     * @param \CorahnRin\CharactersBundle\Entity\Artifacts $artifacts
     * @return Characters
     */
    public function addArtifact(\CorahnRin\CharactersBundle\Entity\Artifacts $artifacts)
    {
        $this->artifacts[] = $artifacts;

        return $this;
    }

    /**
     * Remove artifacts
     *
     * @param \CorahnRin\CharactersBundle\Entity\Artifacts $artifacts
     */
    public function removeArtifact(\CorahnRin\CharactersBundle\Entity\Artifacts $artifacts)
    {
        $this->artifacts->removeElement($artifacts);
    }

    /**
     * Get artifacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArtifacts()
    {
        return $this->artifacts;
    }

    /**
     * Add miracles
     *
     * @param \CorahnRin\CharactersBundle\Entity\Miracles $miracles
     * @return Characters
     */
    public function addMiracle(\CorahnRin\CharactersBundle\Entity\Miracles $miracles)
    {
        $this->miracles[] = $miracles;

        return $this;
    }

    /**
     * Remove miracles
     *
     * @param \CorahnRin\CharactersBundle\Entity\Miracles $miracles
     */
    public function removeMiracle(\CorahnRin\CharactersBundle\Entity\Miracles $miracles)
    {
        $this->miracles->removeElement($miracles);
    }

    /**
     * Get miracles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMiracles()
    {
        return $this->miracles;
    }

    /**
     * Add ogham
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ogham $ogham
     * @return Characters
     */
    public function addOgham(\CorahnRin\CharactersBundle\Entity\Ogham $ogham)
    {
        $this->ogham[] = $ogham;

        return $this;
    }

    /**
     * Remove ogham
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ogham $ogham
     */
    public function removeOgham(\CorahnRin\CharactersBundle\Entity\Ogham $ogham)
    {
        $this->ogham->removeElement($ogham);
    }

    /**
     * Get ogham
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOgham()
    {
        return $this->ogham;
    }

    /**
     * Add weapons
     *
     * @param \CorahnRin\CharactersBundle\Entity\Weapons $weapons
     * @return Characters
     */
    public function addWeapon(\CorahnRin\CharactersBundle\Entity\Weapons $weapons)
    {
        $this->weapons[] = $weapons;

        return $this;
    }

    /**
     * Remove weapons
     *
     * @param \CorahnRin\CharactersBundle\Entity\Weapons $weapons
     */
    public function removeWeapon(\CorahnRin\CharactersBundle\Entity\Weapons $weapons)
    {
        $this->weapons->removeElement($weapons);
    }

    /**
     * Get weapons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWeapons()
    {
        return $this->weapons;
    }

    /**
     * Set socialClasses
     *
     * @param \CorahnRin\CharactersBundle\Entity\SocialClasses $socialClasses
     * @return Characters
     */
    public function setSocialClasses(\CorahnRin\CharactersBundle\Entity\SocialClasses $socialClasses = null)
    {
        $this->socialClasses = $socialClasses;

        return $this;
    }

    /**
     * Get socialClasses
     *
     * @return \CorahnRin\CharactersBundle\Entity\SocialClasses
     */
    public function getSocialClasses()
    {
        return $this->socialClasses;
    }

    /**
     * Set SocialClassDomain1
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $socialClassDomain1
     * @return Characters
     */
    public function setSocialClassDomain1(\CorahnRin\CharactersBundle\Entity\Domains $socialClassDomain1 = null)
    {
        $this->SocialClassDomain1 = $socialClassDomain1;

        return $this;
    }

    /**
     * Get SocialClassDomain1
     *
     * @return \CorahnRin\CharactersBundle\Entity\Domains
     */
    public function getSocialClassDomain1()
    {
        return $this->SocialClassDomain1;
    }

    /**
     * Set SocialClassDomain2
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $socialClassDomain2
     * @return Characters
     */
    public function setSocialClassDomain2(\CorahnRin\CharactersBundle\Entity\Domains $socialClassDomain2 = null)
    {
        $this->SocialClassDomain2 = $socialClassDomain2;

        return $this;
    }

    /**
     * Get SocialClassDomain2
     *
     * @return \CorahnRin\CharactersBundle\Entity\Domains
     */
    public function getSocialClassDomain2()
    {
        return $this->SocialClassDomain2;
    }

    /**
     * Set disorder
     *
     * @param \CorahnRin\CharactersBundle\Entity\Disorders $disorder
     * @return Characters
     */
    public function setDisorder(\CorahnRin\CharactersBundle\Entity\Disorders $disorder = null)
    {
        $this->disorder = $disorder;

        return $this;
    }

    /**
     * Get disorder
     *
     * @return \CorahnRin\CharactersBundle\Entity\Disorders
     */
    public function getDisorder()
    {
        return $this->disorder;
    }

    /**
     * Set job
     *
     * @param \CorahnRin\CharactersBundle\Entity\Jobs $job
     * @return Characters
     */
    public function setJob(\CorahnRin\CharactersBundle\Entity\Jobs $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \CorahnRin\CharactersBundle\Entity\Jobs
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set region
     *
     * @param \CorahnRin\CharactersBundle\Entity\Regions $region
     * @return Characters
     */
    public function setRegion(\CorahnRin\CharactersBundle\Entity\Regions $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \CorahnRin\CharactersBundle\Entity\Regions
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set traitFlaw
     *
     * @param \CorahnRin\CharactersBundle\Entity\Traits $traitFlaw
     * @return Characters
     */
    public function setTraitFlaw(\CorahnRin\CharactersBundle\Entity\Traits $traitFlaw = null)
    {
        $this->traitFlaw = $traitFlaw;

        return $this;
    }

    /**
     * Get traitFlaw
     *
     * @return \CorahnRin\CharactersBundle\Entity\Traits
     */
    public function getTraitFlaw()
    {
        return $this->traitFlaw;
    }

    /**
     * Set traitQuality
     *
     * @param \CorahnRin\CharactersBundle\Entity\Traits $traitQuality
     * @return Characters
     */
    public function setTraitQuality(\CorahnRin\CharactersBundle\Entity\Traits $traitQuality = null)
    {
        $this->traitQuality = $traitQuality;

        return $this;
    }

    /**
     * Get traitQuality
     *
     * @return \CorahnRin\CharactersBundle\Entity\Traits
     */
    public function getTraitQuality()
    {
        return $this->traitQuality;
    }

    /**
     * Add avantages
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharAvtgs $avantages
     * @return Characters
     */
    public function addAvantage(\CorahnRin\CharactersBundle\Entity\CharAvtgs $avantages)
    {
        $this->avantages[] = $avantages;

        return $this;
    }

    /**
     * Remove avantages
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharAvtgs $avantages
     */
    public function removeAvantage(\CorahnRin\CharactersBundle\Entity\CharAvtgs $avantages)
    {
        $this->avantages->removeElement($avantages);
    }

    /**
     * Get avantages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvantages()
    {
        return $this->avantages;
    }

    /**
     * Add domains
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharDomains $domains
     * @return Characters
     */
    public function addDomain(\CorahnRin\CharactersBundle\Entity\CharDomains $domains)
    {
        $this->domains[] = $domains;

        return $this;
    }

    /**
     * Remove domains
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharDomains $domains
     */
    public function removeDomain(\CorahnRin\CharactersBundle\Entity\CharDomains $domains)
    {
        $this->domains->removeElement($domains);
    }

    /**
     * Get domains
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * Get domain
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharDomains $domains
     */
    public function getDomain($id) {
        foreach ($this->domains as $charDomain) {
            if ($charDomain->getDomain()->getId() == $id) {
                return $charDomain;
            }
        }
    }

    /**
     * Add disciplines
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharDisciplines $disciplines
     * @return Characters
     */
    public function addDiscipline(\CorahnRin\CharactersBundle\Entity\CharDisciplines $disciplines)
    {
        $this->disciplines[] = $disciplines;

        return $this;
    }

    /**
     * Remove disciplines
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharDisciplines $disciplines
     */
    public function removeDiscipline(\CorahnRin\CharactersBundle\Entity\CharDisciplines $disciplines)
    {
        $this->disciplines->removeElement($disciplines);
    }

    /**
     * Get disciplines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    /**
     * Get discipline
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharDisciplines $disciplines
     */
    public function getDiscipline($id) {
        foreach ($this->disciplines as $charDiscipline) {
            if ($charDiscipline->getDiscipline()->getId() == $id) {
                return $charDiscipline;
            }
        }
    }

    /**
     * Add ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharWays $ways
     * @return Characters
     */
    public function addWay(\CorahnRin\CharactersBundle\Entity\CharWays $ways)
    {
        $this->ways[] = $ways;

        return $this;
    }

    /**
     * Remove ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharWays $ways
     */
    public function removeWay(\CorahnRin\CharactersBundle\Entity\CharWays $ways)
    {
        $this->ways->removeElement($ways);
    }

    /**
     * Get ways
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWays()
    {
        return $this->ways;
    }

    /**
     * Get way
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharWays $ways
     */
    public function getWay($shortName) {
        foreach ($this->ways as $charWay) {
            if ($charWay->getWay()->getShortName() == $shortName) {
                return $charWay;
            }
        }
    }

    /**
     * Add flux
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharFlux $flux
     * @return Characters
     */
    public function addFlux(\CorahnRin\CharactersBundle\Entity\CharFlux $flux)
    {
        $this->flux[] = $flux;

        return $this;
    }

    /**
     * Remove flux
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharFlux $flux
     */
    public function removeFlux(\CorahnRin\CharactersBundle\Entity\CharFlux $flux)
    {
        $this->flux->removeElement($flux);
    }

    /**
     * Get flux
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFlux()
    {
        return $this->flux;
    }

    /**
     * Add modifications
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharModifications $modifications
     * @return Characters
     */
    public function addModification(\CorahnRin\CharactersBundle\Entity\CharModifications $modifications)
    {
        $this->modifications[] = $modifications;

        return $this;
    }

    /**
     * Remove modifications
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharModifications $modifications
     */
    public function removeModification(\CorahnRin\CharactersBundle\Entity\CharModifications $modifications)
    {
        $this->modifications->removeElement($modifications);
    }

    /**
     * Get modifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModifications()
    {
        return $this->modifications;
    }

    /**
     * Add setbacks
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharSetbacks $setbacks
     * @return Characters
     */
    public function addSetback(\CorahnRin\CharactersBundle\Entity\CharSetbacks $setbacks)
    {
        $this->setbacks[] = $setbacks;

        return $this;
    }

    /**
     * Remove setbacks
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharSetbacks $setbacks
     */
    public function removeSetback(\CorahnRin\CharactersBundle\Entity\CharSetbacks $setbacks)
    {
        $this->setbacks->removeElement($setbacks);
    }

    /**
     * Get setbacks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSetbacks()
    {
        return $this->setbacks;
    }

    /**
     * Set user
     *
     * @param \CorahnRin\UsersBundle\Entity\Users $user
     * @return Characters
     */
    public function setUser(\CorahnRin\UsersBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CorahnRin\UsersBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set game
     *
     * @param \CorahnRin\CharactersBundle\Entity\Games $game
     * @return Characters
     */
    public function setGame(\CorahnRin\CharactersBundle\Entity\Games $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \CorahnRin\CharactersBundle\Entity\Games
     */
    public function getGame()
    {
        return $this->game;
    }


    /*-------------------------------------------------*/
    /*-------------------------------------------------*/
    /*-------Méthodes de récupération de données-------*/
    /*-------------------------------------------------*/
    /*-------------------------------------------------*/

    public function getPotential(){
        $creativity = $this->getWay('cre')->getScore();
        if ($creativity == 1) {
            return 1;
        } elseif ($creativity >= 2 && $creativity <= 4) {
            return 2;
        } elseif ($creativity == 5) {
            return 3;
        } else {
            throw new Exception('Le calcul du potentiel du personnage a renvoyé une erreur');
        }
    }

    public function getAttackScore($type = 'melee', $discipline = null, $potential = '') {

        // Récupération du score de voie
        $way = $this->getWay('com')->getScore();

        // Définition de l'id des domaines "Combat au contact" et "Tir & lancer"
        if ($type === 'melee') {
            $domain_id = 2;
        } elseif ($type === 'ranged') {
            $domain_id = 14;
        } else {
            throw new Exception('Vous devez indiquer un type d\'attaque entre "melee" et "ranged".');
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
     * Set speedExp
     *
     * @param integer $speedExp
     * @return Characters
     */
    public function setSpeedExp($speedExp)
    {
        $this->speedExp = $speedExp;

        return $this;
    }

    /**
     * Get speedExp
     *
     * @return integer
     */
    public function getSpeedExp()
    {
        return $this->speedExp;
    }

    /**
     * Set defenseExp
     *
     * @param integer $defenseExp
     * @return Characters
     */
    public function setDefenseExp($defenseExp)
    {
        $this->defenseExp = $defenseExp;

        return $this;
    }

    /**
     * Get defenseExp
     *
     * @return integer
     */
    public function getDefenseExp()
    {
        return $this->defenseExp;
    }

    /**
     * Set mentalResistExp
     *
     * @param integer $mentalResistExp
     * @return Characters
     */
    public function setMentalResistExp($mentalResistExp)
    {
        $this->mentalResistExp = $mentalResistExp;

        return $this;
    }

    /**
     * Get mentalResistExp
     *
     * @return integer
     */
    public function getMentalResistExp()
    {
        return $this->mentalResistExp;
    }

    /**
     * Set hardening
     *
     * @param integer $hardening
     * @return Characters
     */
    public function setHardening($hardening)
    {
        $this->hardening = $hardening;

        return $this;
    }

    /**
     * Get hardening
     *
     * @return integer
     */
    public function getHardening()
    {
        return $this->hardening;
    }
}

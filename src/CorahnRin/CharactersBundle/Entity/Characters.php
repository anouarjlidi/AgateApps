<?php

namespace CorahnRin\CharactersBundle\Entity;

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
     * @ORM\ManyToMany(targetEntity="Armors", inversedBy="Characters")
     * @ORM\JoinTable(name="char_armors",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_armors", referencedColumnName="id")
     *   }
     * )
     */
    private $Armors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Artifacts", inversedBy="Characters")
     * @ORM\JoinTable(name="char_artifacts",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_artifacts", referencedColumnName="id")
     *   }
     * )
     */
    private $Artifacts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Avdesv", mappedBy="Characters")
     */
    private $Avdesv;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Disciplines", mappedBy="Characters")
     */
    private $Disciplines;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Domains", inversedBy="Characters")
     * @ORM\JoinTable(name="char_domains",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_domains", referencedColumnName="id")
     *   }
     * )
     */
    private $Domains;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Flux", inversedBy="Characters")
     * @ORM\JoinTable(name="char_flux",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_flux", referencedColumnName="id")
     *   }
     * )
     */
    private $Flux;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Miracles", mappedBy="Characters")
     */
    private $Miracles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ogham", inversedBy="Characters")
     * @ORM\JoinTable(name="char_ogham",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ogham", referencedColumnName="id")
     *   }
     * )
     */
    private $Ogham;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ways", inversedBy="Characters")
     * @ORM\JoinTable(name="char_ways",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ways", referencedColumnName="id")
     *   }
     * )
     */
    private $Ways;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Weapons", inversedBy="Characters")
     * @ORM\JoinTable(name="char_weapons",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_characters", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_weapons", referencedColumnName="id")
     *   }
     * )
     */
    private $Weapons;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Revers", mappedBy="Characters")
     */
    private $Revers;

    /**
     * @var \CharSocialClass
     *
     * @ORM\ManyToOne(targetEntity="CharSocialClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_char_social_class", referencedColumnName="id")
     * })
     */
    private $CharSocialClass;

    /**
     * @var \Desordres
     *
     * @ORM\ManyToOne(targetEntity="Desordres")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_desordres", referencedColumnName="id")
     * })
     */
    private $Desordres;

    /**
     * @var \Jobs
     *
     * @ORM\ManyToOne(targetEntity="Jobs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_jobs", referencedColumnName="id")
     * })
     */
    private $Jobs;

    /**
     * @var \Regions
     *
     * @ORM\ManyToOne(targetEntity="Regions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_regions", referencedColumnName="id")
     * })
     */
    private $Regions;

    /**
     * @var \Traits
     *
     * @ORM\ManyToOne(targetEntity="Traits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_traits_flaw", referencedColumnName="id")
     * })
     */
    private $TraitsFlaw;

    /**
     * @var \Traits
     *
     * @ORM\ManyToOne(targetEntity="Traits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_traits_quality", referencedColumnName="id")
     * })
     */
    private $TraitsQuality;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\UsersBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_users", referencedColumnName="id")
     * })
     */
    private $Users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Armors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Artifacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Avdesv = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Disciplines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Domains = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Flux = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Miracles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Ogham = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Ways = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Weapons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Revers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set inventory
     *
     * @param string $inventory
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
     * @return string 
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set money
     *
     * @param string $money
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
     * @return string 
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
     * Set charContent
     *
     * @param string $charContent
     * @return Characters
     */
    public function setCharContent($charContent)
    {
        $this->charContent = $charContent;
    
        return $this;
    }

    /**
     * Get charContent
     *
     * @return string 
     */
    public function getCharContent()
    {
        return $this->charContent;
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
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return Characters
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return integer 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param integer $dateUpdated
     * @return Characters
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    
        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return integer 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Add Armors
     *
     * @param \CorahnRin\CharactersBundle\Entity\Armors $armors
     * @return Characters
     */
    public function addArmor(\CorahnRin\CharactersBundle\Entity\Armors $armors)
    {
        $this->Armors[] = $armors;
    
        return $this;
    }

    /**
     * Remove Armors
     *
     * @param \CorahnRin\CharactersBundle\Entity\Armors $armors
     */
    public function removeArmor(\CorahnRin\CharactersBundle\Entity\Armors $armors)
    {
        $this->Armors->removeElement($armors);
    }

    /**
     * Get Armors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArmors()
    {
        return $this->Armors;
    }

    /**
     * Add Artifacts
     *
     * @param \CorahnRin\CharactersBundle\Entity\Artifacts $artifacts
     * @return Characters
     */
    public function addArtifact(\CorahnRin\CharactersBundle\Entity\Artifacts $artifacts)
    {
        $this->Artifacts[] = $artifacts;
    
        return $this;
    }

    /**
     * Remove Artifacts
     *
     * @param \CorahnRin\CharactersBundle\Entity\Artifacts $artifacts
     */
    public function removeArtifact(\CorahnRin\CharactersBundle\Entity\Artifacts $artifacts)
    {
        $this->Artifacts->removeElement($artifacts);
    }

    /**
     * Get Artifacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArtifacts()
    {
        return $this->Artifacts;
    }

    /**
     * Add Avdesv
     *
     * @param \CorahnRin\CharactersBundle\Entity\Avdesv $avdesv
     * @return Characters
     */
    public function addAvdesv(\CorahnRin\CharactersBundle\Entity\Avdesv $avdesv)
    {
        $this->Avdesv[] = $avdesv;
    
        return $this;
    }

    /**
     * Remove Avdesv
     *
     * @param \CorahnRin\CharactersBundle\Entity\Avdesv $avdesv
     */
    public function removeAvdesv(\CorahnRin\CharactersBundle\Entity\Avdesv $avdesv)
    {
        $this->Avdesv->removeElement($avdesv);
    }

    /**
     * Get Avdesv
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAvdesv()
    {
        return $this->Avdesv;
    }

    /**
     * Add Disciplines
     *
     * @param \CorahnRin\CharactersBundle\Entity\Disciplines $disciplines
     * @return Characters
     */
    public function addDiscipline(\CorahnRin\CharactersBundle\Entity\Disciplines $disciplines)
    {
        $this->Disciplines[] = $disciplines;
    
        return $this;
    }

    /**
     * Remove Disciplines
     *
     * @param \CorahnRin\CharactersBundle\Entity\Disciplines $disciplines
     */
    public function removeDiscipline(\CorahnRin\CharactersBundle\Entity\Disciplines $disciplines)
    {
        $this->Disciplines->removeElement($disciplines);
    }

    /**
     * Get Disciplines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDisciplines()
    {
        return $this->Disciplines;
    }

    /**
     * Add Domains
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domains
     * @return Characters
     */
    public function addDomain(\CorahnRin\CharactersBundle\Entity\Domains $domains)
    {
        $this->Domains[] = $domains;
    
        return $this;
    }

    /**
     * Remove Domains
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domains
     */
    public function removeDomain(\CorahnRin\CharactersBundle\Entity\Domains $domains)
    {
        $this->Domains->removeElement($domains);
    }

    /**
     * Get Domains
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDomains()
    {
        return $this->Domains;
    }

    /**
     * Add Flux
     *
     * @param \CorahnRin\CharactersBundle\Entity\Flux $flux
     * @return Characters
     */
    public function addFlux(\CorahnRin\CharactersBundle\Entity\Flux $flux)
    {
        $this->Flux[] = $flux;
    
        return $this;
    }

    /**
     * Remove Flux
     *
     * @param \CorahnRin\CharactersBundle\Entity\Flux $flux
     */
    public function removeFlux(\CorahnRin\CharactersBundle\Entity\Flux $flux)
    {
        $this->Flux->removeElement($flux);
    }

    /**
     * Get Flux
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFlux()
    {
        return $this->Flux;
    }

    /**
     * Add Miracles
     *
     * @param \CorahnRin\CharactersBundle\Entity\Miracles $miracles
     * @return Characters
     */
    public function addMiracle(\CorahnRin\CharactersBundle\Entity\Miracles $miracles)
    {
        $this->Miracles[] = $miracles;
    
        return $this;
    }

    /**
     * Remove Miracles
     *
     * @param \CorahnRin\CharactersBundle\Entity\Miracles $miracles
     */
    public function removeMiracle(\CorahnRin\CharactersBundle\Entity\Miracles $miracles)
    {
        $this->Miracles->removeElement($miracles);
    }

    /**
     * Get Miracles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMiracles()
    {
        return $this->Miracles;
    }

    /**
     * Add Ogham
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ogham $ogham
     * @return Characters
     */
    public function addOgham(\CorahnRin\CharactersBundle\Entity\Ogham $ogham)
    {
        $this->Ogham[] = $ogham;
    
        return $this;
    }

    /**
     * Remove Ogham
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ogham $ogham
     */
    public function removeOgham(\CorahnRin\CharactersBundle\Entity\Ogham $ogham)
    {
        $this->Ogham->removeElement($ogham);
    }

    /**
     * Get Ogham
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOgham()
    {
        return $this->Ogham;
    }

    /**
     * Add Ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ways $ways
     * @return Characters
     */
    public function addWay(\CorahnRin\CharactersBundle\Entity\Ways $ways)
    {
        $this->Ways[] = $ways;
    
        return $this;
    }

    /**
     * Remove Ways
     *
     * @param \CorahnRin\CharactersBundle\Entity\Ways $ways
     */
    public function removeWay(\CorahnRin\CharactersBundle\Entity\Ways $ways)
    {
        $this->Ways->removeElement($ways);
    }

    /**
     * Get Ways
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWays()
    {
        return $this->Ways;
    }

    /**
     * Add Weapons
     *
     * @param \CorahnRin\CharactersBundle\Entity\Weapons $weapons
     * @return Characters
     */
    public function addWeapon(\CorahnRin\CharactersBundle\Entity\Weapons $weapons)
    {
        $this->Weapons[] = $weapons;
    
        return $this;
    }

    /**
     * Remove Weapons
     *
     * @param \CorahnRin\CharactersBundle\Entity\Weapons $weapons
     */
    public function removeWeapon(\CorahnRin\CharactersBundle\Entity\Weapons $weapons)
    {
        $this->Weapons->removeElement($weapons);
    }

    /**
     * Get Weapons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWeapons()
    {
        return $this->Weapons;
    }

    /**
     * Add Revers
     *
     * @param \CorahnRin\CharactersBundle\Entity\Revers $revers
     * @return Characters
     */
    public function addRever(\CorahnRin\CharactersBundle\Entity\Revers $revers)
    {
        $this->Revers[] = $revers;
    
        return $this;
    }

    /**
     * Remove Revers
     *
     * @param \CorahnRin\CharactersBundle\Entity\Revers $revers
     */
    public function removeRever(\CorahnRin\CharactersBundle\Entity\Revers $revers)
    {
        $this->Revers->removeElement($revers);
    }

    /**
     * Get Revers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRevers()
    {
        return $this->Revers;
    }

    /**
     * Set CharSocialClass
     *
     * @param \CorahnRin\CharactersBundle\Entity\CharSocialClass $charSocialClass
     * @return Characters
     */
    public function setCharSocialClass(\CorahnRin\CharactersBundle\Entity\CharSocialClass $charSocialClass = null)
    {
        $this->CharSocialClass = $charSocialClass;
    
        return $this;
    }

    /**
     * Get CharSocialClass
     *
     * @return \CorahnRin\CharactersBundle\Entity\CharSocialClass 
     */
    public function getCharSocialClass()
    {
        return $this->CharSocialClass;
    }

    /**
     * Set Desordres
     *
     * @param \CorahnRin\CharactersBundle\Entity\Desordres $desordres
     * @return Characters
     */
    public function setDesordres(\CorahnRin\CharactersBundle\Entity\Desordres $desordres = null)
    {
        $this->Desordres = $desordres;
    
        return $this;
    }

    /**
     * Get Desordres
     *
     * @return \CorahnRin\CharactersBundle\Entity\Desordres 
     */
    public function getDesordres()
    {
        return $this->Desordres;
    }

    /**
     * Set Jobs
     *
     * @param \CorahnRin\CharactersBundle\Entity\Jobs $jobs
     * @return Characters
     */
    public function setJobs(\CorahnRin\CharactersBundle\Entity\Jobs $jobs = null)
    {
        $this->Jobs = $jobs;
    
        return $this;
    }

    /**
     * Get Jobs
     *
     * @return \CorahnRin\CharactersBundle\Entity\Jobs 
     */
    public function getJobs()
    {
        return $this->Jobs;
    }

    /**
     * Set Regions
     *
     * @param \CorahnRin\CharactersBundle\Entity\Regions $regions
     * @return Characters
     */
    public function setRegions(\CorahnRin\CharactersBundle\Entity\Regions $regions = null)
    {
        $this->Regions = $regions;
    
        return $this;
    }

    /**
     * Get Regions
     *
     * @return \CorahnRin\CharactersBundle\Entity\Regions 
     */
    public function getRegions()
    {
        return $this->Regions;
    }

    /**
     * Set TraitsFlaw
     *
     * @param \CorahnRin\CharactersBundle\Entity\Traits $traitsFlaw
     * @return Characters
     */
    public function setTraitsFlaw(\CorahnRin\CharactersBundle\Entity\Traits $traitsFlaw = null)
    {
        $this->TraitsFlaw = $traitsFlaw;
    
        return $this;
    }

    /**
     * Get TraitsFlaw
     *
     * @return \CorahnRin\CharactersBundle\Entity\Traits 
     */
    public function getTraitsFlaw()
    {
        return $this->TraitsFlaw;
    }

    /**
     * Set TraitsQuality
     *
     * @param \CorahnRin\CharactersBundle\Entity\Traits $traitsQuality
     * @return Characters
     */
    public function setTraitsQuality(\CorahnRin\CharactersBundle\Entity\Traits $traitsQuality = null)
    {
        $this->TraitsQuality = $traitsQuality;
    
        return $this;
    }

    /**
     * Get TraitsQuality
     *
     * @return \CorahnRin\CharactersBundle\Entity\Traits 
     */
    public function getTraitsQuality()
    {
        return $this->TraitsQuality;
    }

    /**
     * Set Users
     *
     * @param \CorahnRin\CharactersBundle\Entity\Users $users
     * @return Characters
     */
    public function setUsers(\CorahnRin\CharactersBundle\Entity\Users $users = null)
    {
        $this->Users = $users;
    
        return $this;
    }

    /**
     * Get Users
     *
     * @return \CorahnRin\CharactersBundle\Entity\Users 
     */
    public function getUsers()
    {
        return $this->Users;
    }
}
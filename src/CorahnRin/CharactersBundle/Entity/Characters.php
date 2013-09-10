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
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

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
     * @var \CharSocialClass
     *
     * @ORM\ManyToOne(targetEntity="CharSocialClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_char_social_class", referencedColumnName="id")
     * })
     */
    private $CharSocialClass;

    /**
     * @var \Disorders
     *
     * @ORM\ManyToOne(targetEntity="Disorders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_disorders", referencedColumnName="id")
     * })
     */
    private $disorder;

    /**
     * @var \Jobs
     *
     * @ORM\ManyToOne(targetEntity="Jobs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_jobs", referencedColumnName="id")
     * })
     */
    private $job;

    /**
     * @var \Regions
     *
     * @ORM\ManyToOne(targetEntity="Regions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_regions", referencedColumnName="id")
     * })
     */
    private $region;

    /**
     * @var \Traits
     *
     * @ORM\ManyToOne(targetEntity="Traits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_traits_flaw", referencedColumnName="id")
     * })
     */
    private $traitFlaw;

    /**
     * @var \Traits
     *
     * @ORM\ManyToOne(targetEntity="Traits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_traits_quality", referencedColumnName="id")
     * })
     */
    private $traitQuality;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\UsersBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_users", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Armors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Artifacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Avdesv = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Miracles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Ogham = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Weapons = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set content
     *
     * @param string $content
     * @return Characters
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
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
}
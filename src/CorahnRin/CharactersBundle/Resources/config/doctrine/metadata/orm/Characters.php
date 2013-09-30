<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Characters
 *
 * @ORM\Entity
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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1, nullable=false)
     */
    private $sex;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=false)
     */
    private $inventory;

    /**
     * @var \CorahnRin\CharactersBundle\Classes\Money
     *
     * @ORM\Column(type="object", nullable=false)
     */
    private $money;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $orientation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25, nullable=false)
     */
    private $geoLiving;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $age;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $mentalResist;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=false)
     */
    private $health;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $stamina;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $survival;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $speed;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $defense;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $rindath;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $exaltation;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $experienceActual;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $experienceSpent;

    /**
     * @var \Datetime
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \Datetime

     * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Armors")
     */
    private $armors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Artifacts")
     */
    private $artifacts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Miracles", mappedBy="characters")
     */
    private $miracles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ogham", inversedBy="characters")
     */
    private $ogham;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Weapons", inversedBy="characters")
     */
    private $weapons;

    /**
     * @var \CharSocialClass
     *
     * @ORM\OneToOne(targetEntity="CharSocialClass", mappedBy="character")
     */
    private $socialClass;

    /**
     * @var \Disorders
     *
     * @ORM\ManyToOne(targetEntity="Disorders")
     */
    private $disorder;

    /**
     * @var \Jobs
     *
     * @ORM\ManyToOne(targetEntity="Jobs")
     */
    private $job;

    /**
     * @var \Regions
     *
     * @ORM\ManyToOne(targetEntity="Regions")
     */
    private $region;

    /**
     * @var \Traits
     * @ORM\ManyToOne(targetEntity="Traits")
     */
    private $traitFlaw;

    /**
     * @var \Traits
     * @ORM\ManyToOne(targetEntity="Traits")
     */
    private $traitQuality;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharAvtgs", mappedBy="character")
     */
    private $avantages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharDomains", mappedBy="character")
     */
    private $domains;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharDisciplines", mappedBy="character")
     */
    private $disciplines;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharFlux", mappedBy="character")
     */
    private $flux;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CharModifications", mappedBy="character")
     */
    private $modifications;

    /**
     * @var \Users
     * @ORM\ManyToOne(targetEntity="CorahnRin\UsersBundle\Entity\Users", inversedBy="characters")
     */
    private $user;
	
	private $baseChar;
}
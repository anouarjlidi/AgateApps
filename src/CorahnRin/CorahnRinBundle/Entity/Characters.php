<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Entity;

use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharAdvantages;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDisciplines;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDomains;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharFlux;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharSetbacks;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharWays;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\HealthCondition;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\Money;
use CorahnRin\CorahnRinBundle\Entity\Traits\CharacterGettersSetters;
use CorahnRin\CorahnRinBundle\Exception\CharactersException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EsterenMaps\MapsBundle\Entity\Zones;
use Gedmo\Mapping\Annotation as Gedmo;
use Pierstoval\Bundle\CharacterManagerBundle\Entity\Character as BaseCharacter;
use UserBundle\Entity\User;

/**
 * Characters.
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\CharactersRepository")
 * @ORM\Table(name="characters", uniqueConstraints={@ORM\UniqueConstraint(name="idcUnique", columns={"name_slug", "user_id"})})
 */
class Characters extends BaseCharacter
{
    public const FEMALE = 'character.sex.female';
    public const MALE   = 'character.sex.male';

    public const COMBAT_ATTITUDE_STANDARD  = 'character.combat_attitude.standard';
    public const COMBAT_ATTITUDE_OFFENSIVE = 'character.combat_attitude.offensive';
    public const COMBAT_ATTITUDE_DEFENSIVE = 'character.combat_attitude.defensive';
    public const COMBAT_ATTITUDE_QUICK     = 'character.combat_attitude.quick';
    public const COMBAT_ATTITUDE_MOVEMENT  = 'character.combat_attitude.movement';

    public const COMBAT_ATTITUDES = [
        self::COMBAT_ATTITUDE_STANDARD,
        self::COMBAT_ATTITUDE_OFFENSIVE,
        self::COMBAT_ATTITUDE_DEFENSIVE,
        self::COMBAT_ATTITUDE_QUICK,
        self::COMBAT_ATTITUDE_MOVEMENT,
    ];

    use CharacterGettersSetters;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_slug", type="string", length=255, nullable=false)
     * @Gedmo\Slug(fields={"name"}, unique=false)
     */
    protected $nameSlug;

    /**
     * @var string
     *
     * @ORM\Column(name="player_name", type="string", length=255, nullable=false)
     */
    protected $playerName;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", nullable=false, options={"default":0})
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=1, nullable=false)
     */
    protected $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="story", type="text")
     */
    protected $story;

    /**
     * @var string
     *
     * @ORM\Column(name="facts", type="text")
     */
    protected $facts;

    /**
     * @var array
     *
     * @ORM\Column(name="inventory", type="simple_array")
     */
    protected $inventory;

    /**
     * @var array
     *
     * @ORM\Column(name="treasures", type="simple_array")
     */
    protected $treasures;

    /**
     * @var Money
     *
     * @ORM\Embedded(class="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\Money", columnPrefix="daol_")
     */
    protected $money;

    /**
     * @var string
     *
     * @ORM\Column(name="orientation", type="string", length=30)
     */
    protected $orientation;

    /**
     * @var GeoEnvironments
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\GeoEnvironments")
     */
    protected $geoLiving;

    /**
     * @var int
     *
     * @ORM\Column(name="trauma", type="smallint", options={"default":0})
     */
    protected $trauma = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="trauma_permanent", type="smallint", options={"default": 0})
     */
    protected $traumaPermanent = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="hardening", type="smallint", options={"default":0})
     */
    protected $hardening = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="smallint", nullable=false)
     */
    protected $age;

    /**
     * @var int
     *
     * @ORM\Column(name="mental_resist", type="smallint")
     */
    protected $mentalResist = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="mental_resist_bonus", type="smallint")
     */
    protected $mentalResistBonus = 0;

    /**
     * @var HealthCondition
     *
     * @ORM\Embedded(class="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\HealthCondition", columnPrefix="health_")
     */
    protected $health;

    /**
     * @var HealthCondition
     *
     * @ORM\Embedded(class="CorahnRin\CorahnRinBundle\Entity\CharacterProperties\HealthCondition", columnPrefix="max_health_")
     */
    protected $maxHealth;

    /**
     * @var int
     *
     * @ORM\Column(name="stamina", type="smallint")
     */
    protected $stamina = 10;

    /**
     * @var int
     *
     * @ORM\Column(name="stamina_bonus", type="smallint")
     */
    protected $staminaBonus = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="survival", type="smallint")
     */
    protected $survival = 3;

    /**
     * @var int
     *
     * @ORM\Column(name="speed", type="smallint")
     */
    protected $speed = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="speed_bonus", type="smallint")
     */
    protected $speedBonus = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="defense", type="smallint")
     */
    protected $defense = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="defense_bonus", type="smallint")
     */
    protected $defenseBonus = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="rindath", type="smallint")
     */
    protected $rindath = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="rindathMax", type="smallint")
     */
    protected $rindathMax = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="exaltation", type="smallint")
     */
    protected $exaltation = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="exaltation_max", type="smallint")
     */
    protected $exaltationMax = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="experience_actual", type="smallint")
     */
    protected $experienceActual = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="experience_spent", type="smallint")
     */
    protected $experienceSpent = 0;

    /**
     * @var Peoples
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Peoples")
     */
    protected $people;

    /**
     * @var Armors[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Armors")
     */
    protected $armors;

    /**
     * @var Artifacts[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Artifacts")
     */
    protected $artifacts;

    /**
     * @var Miracles[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Miracles")
     */
    protected $miracles;

    /**
     * @var Ogham[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Ogham")
     */
    protected $ogham;

    /**
     * @var Weapons[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\Weapons")
     */
    protected $weapons;

    /**
     * @var CombatArts[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CorahnRin\CorahnRinBundle\Entity\CombatArts")
     */
    protected $combatArts;

    /**
     * @var SocialClasses
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\SocialClasses")
     */
    protected $socialClass;

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
    protected $mentalDisorder;

    /**
     * @var Jobs
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Jobs")
     */
    protected $job;

    /**
     * @var Zones
     *
     * @ORM\ManyToOne(targetEntity="EsterenMaps\MapsBundle\Entity\Zones")
     */
    protected $birthPlace;

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
    protected $charAdvantages;

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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @var Games
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Games", inversedBy="characters")
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
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->armors         = new ArrayCollection();
        $this->artifacts      = new ArrayCollection();
        $this->miracles       = new ArrayCollection();
        $this->ogham          = new ArrayCollection();
        $this->weapons        = new ArrayCollection();
        $this->combatArts     = new ArrayCollection();
        $this->charAdvantages = new ArrayCollection();
        $this->domains        = new ArrayCollection();
        $this->disciplines    = new ArrayCollection();
        $this->ways           = new ArrayCollection();
        $this->flux           = new ArrayCollection();
        $this->setbacks       = new ArrayCollection();
    }

    /*-------------------------------------------------*/
    /*-------------------------------------------------*/
    /*--------- Methods used for entity logic ---------*/
    /*-------------------------------------------------*/
    /*-------------------------------------------------*/

    /**
     * @return CharAdvantages[]
     */
    public function getAdvantages(): array
    {
        $advantages = [];

        foreach ($this->charAdvantages as $charAdvantage) {
            if (!$charAdvantage->getAdvantage()->isDesv()) {
                $advantages[] = $charAdvantage;
            }
        }

        return $advantages;
    }

    /**
     * @return CharAdvantages[]
     */
    public function getDisadvantages(): array
    {
        $advantages = [];

        foreach ($this->charAdvantages as $charAdvantage) {
            if ($charAdvantage->getAdvantage()->isDesv()) {
                $advantages[] = $charAdvantage;
            }
        }

        return $advantages;
    }

    /**
     * Conscience is determined by "Reason" and "Conviction" ways.
     *
     * @return string
     */
    public function getConsciousness(): string
    {
        return $this->getWay('rai')->getScore() + $this->getWay('ide')->getScore();
    }

    /**
     * Conscience is determined by "Creativity" and "Combativity" ways.
     *
     * @return string
     */
    public function getInstinct(): string
    {
        return $this->getWay('cre')->getScore() + $this->getWay('com')->getScore();
    }

    /**
     * Get a domain based on its id or name.
     *
     * @param int|string $id
     *
     * @return CharDomains|null
     */
    public function getDomain($id): ?CharacterProperties\CharDomains
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
     * @param int|Domains $domain
     *
     * @return CharDisciplines[]
     */
    public function getDisciplineFromDomain($domain): array
    {
        if ($domain instanceof Domains) {
            $domain = $domain->getId();
        }

        $disciplines = [];

        foreach ($this->disciplines as $discipline) {
            if ($discipline->getDomain()->getId() === $domain) {
                $disciplines[] = $discipline;
            }
        }

        return $disciplines;
    }

    /**
     * @param string $shortName
     *
     * @return CharWays|null
     */
    public function getWay($shortName): ?CharacterProperties\CharWays
    {
        foreach ($this->ways as $charWay) {
            if (
                $charWay instanceof CharWays &&
                ($charWay->getWay()->getShortName() === $shortName || $charWay->getWay()->getId() === $shortName)
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
    public function getDiscipline($id): ?CharacterProperties\CharDisciplines
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
    public function getBaseDefense(): int
    {
        $rai = $this->getWay('rai')->getScore();
        $emp = $this->getWay('emp')->getScore();

        return $rai + $emp + 5;
    }

    /**
     * @param string $attitude
     *
     * @return int|null
     */
    public function getTotalDefense($attitude = self::COMBAT_ATTITUDE_STANDARD): ?int
    {
        $this->validateCombatAttitude($attitude);

        $defense = $this->getBaseDefense() + $this->defense + $this->defenseBonus;

        switch ($attitude) {
            case self::COMBAT_ATTITUDE_DEFENSIVE:
            case self::COMBAT_ATTITUDE_MOVEMENT:
                $defense += $this->getPotential();
                break;
            case self::COMBAT_ATTITUDE_OFFENSIVE:
                $defense -= $this->getPotential();
                break;
        }

        return $defense;
    }

    /**
     * Base speed is calculated from "Combativity" and "Empathy".
     *
     * @return int
     */
    public function getBaseSpeed(): int
    {
        $com = $this->getWay('com')->getScore();
        $emp = $this->getWay('emp')->getScore();

        return $com + $emp;
    }

    /**
     * @param string $attitude
     *
     * @return int|null
     */
    public function getTotalSpeed($attitude = self::COMBAT_ATTITUDE_STANDARD): ?int
    {
        $this->validateCombatAttitude($attitude);

        $speed = $this->getBaseSpeed() + $this->speed + $this->speedBonus;

        if (self::COMBAT_ATTITUDE_QUICK === $attitude) {
            $speed += $this->getPotential();
        }

        return $speed;
    }

    /**
     * Base mental resistance is calculated from "Conviction".
     *
     * @return int
     */
    public function getBaseMentalResist(): int
    {
        $ide = $this->getWay('ide')->getScore();

        return $ide + 5;
    }

    /**
     * @return int
     */
    public function getTotalMentalResist(): int
    {
        return $this->getBaseMentalResist() + $this->mentalResist + $this->mentalResistBonus;
    }

    /**
     * @return int
     *
     * @throws CharactersException
     */
    public function getPotential(): ?int
    {
        $creativity = $this->getWay('cre')->getScore();

        switch ($creativity) {
            case 1:
                return 1;
                break;
            case 2:
            case 3:
            case 4:
                return 2;
            break;
            case 5:
                return 3;
                break;
            default:
                throw new CharactersException('Le calcul du potentiel du personnage a renvoyé une erreur');
        }
    }

    /**
     * Calculate melee attack score.
     *
     * @param int|string $discipline
     * @param string     $potentialOperator Can be "+" or "-"
     *
     * @return int
     */
    public function getMeleeAttackScore($discipline = null, $potentialOperator = ''): int
    {
        return $this->getAttackScore('melee', $discipline, $potentialOperator);
    }

    /**
     * Retourne le score de base du type de combat spécifié dans $type.
     * Si $discipline est mentionné, il doit s'agir d'un identifiant valide de discipline,.
     *
     * @param string     $type
     * @param int|string $discipline
     * @param string     $attitude
     *
     * @throws CharactersException
     *
     * @return int
     */
    public function getAttackScore($type = 'melee', $discipline = null, $attitude = self::COMBAT_ATTITUDE_STANDARD): int
    {
        $this->validateCombatAttitude($attitude);

        // Récupération du score de voie
        $way = $this->getWay('com')->getScore();

        // Définition de l'id des domaines "Combat au contact" et "Tir & lancer"
        if ($type === 'melee') {
            $domain_id = 2;
        } elseif ($type === 'ranged') {
            $domain_id = 14;
        } else {
            throw new CharactersException('Attack can only be "melee" or "ranged".');
        }

        $domain_id = (int) $domain_id;

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

        switch ($attitude) {
            case self::COMBAT_ATTITUDE_OFFENSIVE:
                $attack += $this->getPotential();
                break;
            case self::COMBAT_ATTITUDE_DEFENSIVE:
                $attack -= $this->getPotential();
                break;
            case self::COMBAT_ATTITUDE_MOVEMENT:
                $attack = 0;
                break;
        }

        return $attack;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function hasAdvantage($id): bool
    {
        $id = (int) $id;

        foreach ($this->charAdvantages as $advantage) {
            if ($advantage->getAdvantage()->getId() === $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int  $id
     * @param bool $falseIfAvoided
     *
     * @return bool
     */
    public function hasSetback($id, $falseIfAvoided = true): bool
    {
        $id = (int) $id;

        foreach ($this->setbacks as $setback) {
            if ($setback->getSetback()->getId() === $id) {
                if (true === $falseIfAvoided && $setback->isAvoided()) {
                    continue;
                }

                return true;
            }
        }

        return false;
    }

    /**
     * @param string $attitude
     */
    private function validateCombatAttitude(string $attitude): void
    {
        if (!in_array($attitude, self::COMBAT_ATTITUDES, true)) {
            throw new \InvalidArgumentException("Combat attitude is invalid, $attitude given.");
        }
    }
}

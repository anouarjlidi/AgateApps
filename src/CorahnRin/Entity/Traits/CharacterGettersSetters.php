<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Entity\Traits;

use CorahnRin\Data\Orientation;
use CorahnRin\Entity\Armors;
use CorahnRin\Entity\Artifacts;
use CorahnRin\Entity\CharacterProperties\CharAdvantages;
use CorahnRin\Entity\CharacterProperties\CharDisciplines;
use CorahnRin\Entity\CharacterProperties\CharDomains;
use CorahnRin\Entity\CharacterProperties\CharFlux;
use CorahnRin\Entity\CharacterProperties\CharSetbacks;
use CorahnRin\Entity\CharacterProperties\CharWays;
use CorahnRin\Entity\CharacterProperties\HealthCondition;
use CorahnRin\Entity\CharacterProperties\Money;
use CorahnRin\Entity\CombatArts;
use CorahnRin\Entity\Disorders;
use CorahnRin\Entity\Domains;
use CorahnRin\Entity\Games;
use CorahnRin\Entity\GeoEnvironments;
use CorahnRin\Entity\Jobs;
use CorahnRin\Entity\Miracles;
use CorahnRin\Entity\Ogham;
use CorahnRin\Entity\Peoples;
use CorahnRin\Entity\SocialClasses;
use CorahnRin\Entity\Traits;
use CorahnRin\Entity\Weapons;
use Doctrine\Common\Collections\ArrayCollection;
use EsterenMaps\Entity\Zones;
use Agate\Entity\User;

/**
 * @codeCoverageIgnore
 */
trait CharacterGettersSetters
{
    /** @var ArrayCollection|Armors[] */
    protected $armors;

    /** @var ArrayCollection|Artifacts[] */
    protected $artifacts;

    /** @var ArrayCollection|Miracles[] */
    protected $miracles;

    /** @var ArrayCollection|Ogham[] */
    protected $ogham;

    /** @var ArrayCollection|Weapons[] */
    protected $weapons;

    /** @var ArrayCollection|CombatArts[] */
    protected $combatArts;

    /** @var ArrayCollection|CharAdvantages[] */
    protected $charAdvantages;

    /** @var ArrayCollection|CharDomains[] */
    protected $domains;

    /** @var ArrayCollection|CharDisciplines[] */
    protected $disciplines;

    /** @var ArrayCollection|CharWays[] */
    protected $ways;

    /** @var ArrayCollection|CharFlux[] */
    protected $flux;

    /** @var ArrayCollection|CharSetbacks[] */
    protected $setbacks;

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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setSex($sex): self
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return array
     */
    public function getTreasures()
    {
        return $this->treasures;
    }

    /**
     * @param array $treasures
     *
     * @return $this
     */
    public function setTreasures(array $treasures)
    {
        $this->treasures = $treasures;

        return $this;
    }

    /**
     * @param Money $money
     *
     * @return $this
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
     * @return $this
     */
    public function setOrientation($orientation)
    {
        if (!array_key_exists($orientation, Orientation::getData())) {
            throw new \InvalidArgumentException(sprintf(
                'Orientation must be one value in "%s", "%s" given.',
                implode('", "', array_keys(Orientation::getData())), $orientation
            ));
        }

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
     * @param GeoEnvironments $geoLiving
     *
     * @return $this
     */
    public function setGeoLiving(GeoEnvironments $geoLiving)
    {
        $this->geoLiving = $geoLiving;

        return $this;
    }

    /**
     * @return GeoEnvironments
     */
    public function getGeoLiving()
    {
        return $this->geoLiving;
    }

    /**
     * @param int $trauma
     *
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return int
     */
    public function getMentalResistBonus()
    {
        return $this->mentalResistBonus;
    }

    /**
     * @param int $mentalResistBonus
     *
     * @return $this
     */
    public function setMentalResistBonus($mentalResistBonus)
    {
        $this->mentalResistBonus = $mentalResistBonus;

        return $this;
    }

    /**
     * @param HealthCondition $health
     *
     * @return $this
     */
    public function setHealth(HealthCondition $health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * @return HealthCondition
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @param HealthCondition $maxHealth
     *
     * @return $this
     */
    public function setMaxHealth(HealthCondition $maxHealth)
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }

    /**
     * @return HealthCondition
     */
    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    /**
     * @param int $stamina
     *
     * @return $this
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
     * @return int
     */
    public function getStaminaBonus()
    {
        return $this->staminaBonus;
    }

    /**
     * @param int $staminaBonus
     */
    public function setStaminaBonus($staminaBonus)
    {
        $this->staminaBonus = $staminaBonus;
    }

    /**
     * @param int $survival
     *
     * @return $this
     */
    public function setSurvival($survival)
    {
        $this->survival = $survival;

        return $this;
    }

    /**
     * @return int
     */
    public function getSurvival()
    {
        return $this->survival;
    }

    /**
     * @param int $speed
     *
     * @return $this
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
     * @return int
     */
    public function getSpeedBonus()
    {
        return $this->speedBonus;
    }

    /**
     * @param int $speedBonus
     *
     * @return $this
     */
    public function setSpeedBonus($speedBonus)
    {
        $this->speedBonus = $speedBonus;

        return $this;
    }

    /**
     * @param int $defense
     *
     * @return $this
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
     * @return int
     */
    public function getDefenseBonus()
    {
        return $this->defenseBonus;
    }

    /**
     * @param int $defenseBonus
     */
    public function setDefenseBonus($defenseBonus)
    {
        $this->defenseBonus = $defenseBonus;
    }

    /**
     * @param int $rindath
     *
     * @return $this
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
     * @return int
     */
    public function getRindathMax()
    {
        return $this->rindathMax;
    }

    /**
     * @param int $rindathMax
     *
     * @return $this
     */
    public function setRindathMax($rindathMax)
    {
        $this->rindathMax = $rindathMax;

        return $this;
    }

    /**
     * @param int $exaltation
     *
     * @return $this
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
     * @return int
     */
    public function getExaltationMax()
    {
        return $this->exaltationMax;
    }

    /**
     * @param int $exaltationMax
     *
     * @return $this
     */
    public function setExaltationMax($exaltationMax)
    {
        $this->exaltationMax = $exaltationMax;

        return $this;
    }

    /**
     * @param int $experienceActual
     *
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function addArmor(Armors $armor)
    {
        $this->armors[] = $armor;

        return $this;
    }

    /**
     * @param Armors $armor
     *
     * @return $this
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
     * @return $this
     */
    public function addArtifact(Artifacts $artifact)
    {
        $this->artifacts[] = $artifact;

        return $this;
    }

    /**
     * @param Artifacts $artifact
     *
     * @return $this
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
     * @return $this
     */
    public function addMiracle(Miracles $miracle)
    {
        $this->miracles[] = $miracle;

        return $this;
    }

    /**
     * @param Miracles $miracle
     *
     * @return $this
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
     * @return $this
     */
    public function addOgham(Ogham $ogham)
    {
        $this->ogham[] = $ogham;

        return $this;
    }

    /**
     * @param Ogham $ogham
     *
     * @return $this
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
     * @return $this
     */
    public function addWeapon(Weapons $weapon)
    {
        $this->weapons[] = $weapon;

        return $this;
    }

    /**
     * @param Weapons $weapon
     *
     * @return $this
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
     * @param CombatArts $combatArt
     *
     * @return $this
     */
    public function addCombatArt(CombatArts $combatArt)
    {
        $this->combatArts[] = $combatArt;

        return $this;
    }

    /**
     * @param CombatArts $combatArt
     *
     * @return $this
     */
    public function removeCombatArt(CombatArts $combatArt)
    {
        $this->combatArts->removeElement($combatArt);

        return $this;
    }

    /**
     * @return CombatArts[]
     */
    public function getCombatArts()
    {
        return $this->combatArts;
    }

    /**
     * @param SocialClasses $socialClass
     *
     * @return $this
     */
    public function setSocialClass(SocialClasses $socialClass = null)
    {
        $this->socialClass = $socialClass;

        return $this;
    }

    /**
     * @return SocialClasses
     */
    public function getSocialClass()
    {
        return $this->socialClass;
    }

    /**
     * @param Domains $socialClassDomain1
     *
     * @return $this
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
     * @return $this
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
     * @param Disorders $mentalDisorder
     *
     * @return $this
     */
    public function setMentalDisorder(Disorders $mentalDisorder = null)
    {
        $this->mentalDisorder = $mentalDisorder;

        return $this;
    }

    /**
     * @return Disorders
     */
    public function getMentalDisorder()
    {
        return $this->mentalDisorder;
    }

    /**
     * @param Jobs $job
     *
     * @return $this
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
     * @param Zones $birthPlace
     *
     * @return $this
     */
    public function setBirthPlace(Zones $birthPlace = null)
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    /**
     * @return Zones
     */
    public function getBirthPlace()
    {
        return $this->birthPlace;
    }

    /**
     * @param Traits $flaw
     *
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function addCharAdvantage(CharAdvantages $advantage)
    {
        $this->charAdvantages[] = $advantage;

        return $this;
    }

    /**
     * @param CharAdvantages $advantage
     *
     * @return $this
     */
    public function removeCharAdvantage(CharAdvantages $advantage)
    {
        $this->charAdvantages->removeElement($advantage);

        return $this;
    }

    /**
     * @return CharAdvantages[]
     */
    public function getCharAdvantages()
    {
        return $this->charAdvantages;
    }

    /**
     * @param CharDomains $domain
     *
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function addWay(CharWays $way)
    {
        $this->ways[] = $way;

        return $this;
    }

    public function hasWay(CharWays $charWays): bool
    {
        $id = $charWays->getWay()->getId();
        foreach ($this->ways as $way) {
            if ($id === $way->getWay()->getId()) {
                return true;
            }
        }

        return false;
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
     * @return CharWays[]|ArrayCollection
     */
    public function getWays()
    {
        return $this->ways;
    }

    /**
     * @param CharFlux $flux
     *
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
}

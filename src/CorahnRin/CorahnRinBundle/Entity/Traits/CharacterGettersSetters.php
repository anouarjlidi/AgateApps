<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Entity\Traits;


use CorahnRin\CorahnRinBundle\Entity\Armors;
use CorahnRin\CorahnRinBundle\Entity\Artifacts;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharAdvantages;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDisciplines;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDomains;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharFlux;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharSetbacks;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharWays;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\HealthCondition;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\Money;
use CorahnRin\CorahnRinBundle\Entity\CombatArts;
use CorahnRin\CorahnRinBundle\Entity\Disorders;
use CorahnRin\CorahnRinBundle\Entity\Domains;
use CorahnRin\CorahnRinBundle\Entity\Games;
use CorahnRin\CorahnRinBundle\Entity\GeoEnvironments;
use CorahnRin\CorahnRinBundle\Entity\Jobs;
use CorahnRin\CorahnRinBundle\Entity\Miracles;
use CorahnRin\CorahnRinBundle\Entity\Ogham;
use CorahnRin\CorahnRinBundle\Entity\Peoples;
use CorahnRin\CorahnRinBundle\Entity\SocialClasses;
use CorahnRin\CorahnRinBundle\Entity\Traits;
use CorahnRin\CorahnRinBundle\Entity\Weapons;
use Doctrine\Common\Collections\ArrayCollection;
use EsterenMaps\MapsBundle\Entity\Zones;
use UserBundle\Entity\User;

/**
 * @property ArrayCollection|Armors[] $armors
 * @property ArrayCollection|Artifacts[] $artifacts
 * @property ArrayCollection|Miracles[] $miracles
 * @property ArrayCollection|Ogham[] $ogham
 * @property ArrayCollection|Weapons[] $weapons
 * @property ArrayCollection|CombatArts[] $combatArts
 * @property ArrayCollection|CharAdvantages[] $charAdvantages
 * @property ArrayCollection|CharDomains[] $domains
 * @property ArrayCollection|CharDisciplines[] $disciplines
 * @property ArrayCollection|CharWays[] $ways
 * @property ArrayCollection|CharFlux[] $flux
 * @property ArrayCollection|CharSetbacks[] $setbacks
 */
trait CharacterGettersSetters
{
    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;

        return $this;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
     * @param int $status
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $sex
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param string $description
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $story
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * @param string $facts
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setFacts($facts)
    {
        $this->facts = $facts;

        return $this;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getFacts()
    {
        return $this->facts;
    }

    /**
     * @param array $inventory
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function getTreasures()
    {
        return $this->treasures;
    }

    /**
     * @param array $treasures
     *
     * @return $this
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function setMoney(Money $money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * @return Money
     *
     * @codeCoverageIgnore
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @param string $orientation
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * @param GeoEnvironments $geoLiving
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setGeoLiving(GeoEnvironments $geoLiving)
    {
        $this->geoLiving = $geoLiving;

        return $this;
    }

    /**
     * @return GeoEnvironments
     *
     * @codeCoverageIgnore
     */
    public function getGeoLiving()
    {
        return $this->geoLiving;
    }

    /**
     * @param int $trauma
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setTrauma($trauma)
    {
        $this->trauma = $trauma;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getTrauma()
    {
        return $this->trauma;
    }

    /**
     * @param int $traumaPermanent
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setTraumaPermanent($traumaPermanent)
    {
        $this->traumaPermanent = $traumaPermanent;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getTraumaPermanent()
    {
        return $this->traumaPermanent;
    }

    /**
     * @param int $hardening
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setHardening($hardening)
    {
        $this->hardening = $hardening;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getHardening()
    {
        return $this->hardening;
    }

    /**
     * @param int $age
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $mentalResist
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setMentalResist($mentalResist)
    {
        $this->mentalResist = $mentalResist;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function setHealth(HealthCondition $health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * @return HealthCondition
     *
     * @codeCoverageIgnore
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @param HealthCondition $maxHealth
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setMaxHealth(HealthCondition $maxHealth)
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }

    /**
     * @return HealthCondition
     *
     * @codeCoverageIgnore
     */
    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    /**
     * @param int $stamina
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setStamina($stamina)
    {
        $this->stamina = $stamina;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function setSurvival($survival)
    {
        $this->survival = $survival;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getSurvival()
    {
        return $this->survival;
    }

    /**
     * @param int $speed
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function setRindath($rindath)
    {
        $this->rindath = $rindath;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function setExaltation($exaltation)
    {
        $this->exaltation = $exaltation;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function setExperienceActual($experienceActual)
    {
        $this->experienceActual = $experienceActual;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getExperienceActual()
    {
        return $this->experienceActual;
    }

    /**
     * @param int $experienceSpent
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setExperienceSpent($experienceSpent)
    {
        $this->experienceSpent = $experienceSpent;

        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getExperienceSpent()
    {
        return $this->experienceSpent;
    }

    /**
     * @param \DateTime $created
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     *
     * @codeCoverageIgnore
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $updated
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime
     *
     * @codeCoverageIgnore
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $deleted
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setDeleted(\DateTime $deleted = null)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @return \DateTime
     *
     * @codeCoverageIgnore
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param Peoples $people
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setPeople(Peoples $people = null)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * @return Peoples
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getCombatArts()
    {
        return $this->combatArts;
    }

    /**
     * @param SocialClasses $socialClass
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setSocialClass(SocialClasses $socialClass = null)
    {
        $this->socialClass = $socialClass;

        return $this;
    }

    /**
     * @return SocialClasses
     *
     * @codeCoverageIgnore
     */
    public function getSocialClass()
    {
        return $this->socialClass;
    }

    /**
     * @param Domains $socialClassDomain1
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setSocialClassDomain1(Domains $socialClassDomain1 = null)
    {
        $this->socialClassDomain1 = $socialClassDomain1;

        return $this;
    }

    /**
     * @return Domains
     *
     * @codeCoverageIgnore
     */
    public function getSocialClassDomain1()
    {
        return $this->socialClassDomain1;
    }

    /**
     * @param Domains $socialClassDomain2
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setSocialClassDomain2(Domains $socialClassDomain2 = null)
    {
        $this->socialClassDomain2 = $socialClassDomain2;

        return $this;
    }

    /**
     * @return Domains
     *
     * @codeCoverageIgnore
     */
    public function getSocialClassDomain2()
    {
        return $this->socialClassDomain2;
    }

    /**
     * @param Disorders $mentalDisorder
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setMentalDisorder(Disorders $mentalDisorder = null)
    {
        $this->mentalDisorder = $mentalDisorder;

        return $this;
    }

    /**
     * @return Disorders
     *
     * @codeCoverageIgnore
     */
    public function getMentalDisorder()
    {
        return $this->mentalDisorder;
    }

    /**
     * @param Jobs $job
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setJob(Jobs $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return Jobs
     *
     * @codeCoverageIgnore
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param Zones $birthPlace
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setBirthPlace(Zones $birthPlace = null)
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    /**
     * @return Zones
     *
     * @codeCoverageIgnore
     */
    public function getBirthPlace()
    {
        return $this->birthPlace;
    }

    /**
     * @param Traits $flaw
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setFlaw(Traits $flaw = null)
    {
        $this->flaw = $flaw;

        return $this;
    }

    /**
     * @return Traits
     *
     * @codeCoverageIgnore
     */
    public function getFlaw()
    {
        return $this->flaw;
    }

    /**
     * @param Traits $quality
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setQuality(Traits $quality = null)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * @return Traits
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    /**
     * @param CharWays $way
     *
     * @return $this
     *
     * @codeCoverageIgnore
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
     * @return CharWays[]|ArrayCollection
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getSetbacks()
    {
        return $this->setbacks;
    }

    /**
     * @param User $user
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     *
     * @codeCoverageIgnore
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Games $game
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setGame(Games $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Games
     *
     * @codeCoverageIgnore
     */
    public function getGame()
    {
        return $this->game;
    }
}

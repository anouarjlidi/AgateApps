<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Entity\CharacterProperties;

use CorahnRin\Data\Domains as DomainsData;
use CorahnRin\Exception\InvalidDomain;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\Mapping as ORM;

/**
 * Domains.
 *
 * @ORM\Embeddable
 */
class Domains
{
    /**
     * @ORM\Column(name="craft", type="smallint")
     */
    private $craft;

    /**
     * @ORM\Column(name="craft_bonus", type="smallint")
     */
    private $craftBonus;

    /**
     * @ORM\Column(name="craft_malus", type="smallint")
     */
    private $craftMalus;

    /**
     * @ORM\Column(name="close_combat", type="smallint")
     */
    private $closeCombat;

    /**
     * @ORM\Column(name="close_combat_bonus", type="smallint")
     */
    private $closeCombatBonus;

    /**
     * @ORM\Column(name="close_combat_malus", type="smallint")
     */
    private $closeCombatMalus;

    /**
     * @ORM\Column(name="stealth", type="smallint")
     */
    private $stealth;

    /**
     * @ORM\Column(name="stealth_bonus", type="smallint")
     */
    private $stealthBonus;

    /**
     * @ORM\Column(name="stealth_malus", type="smallint")
     */
    private $stealthMalus;

    /**
     * @ORM\Column(name="magience", type="smallint")
     */
    private $magience;

    /**
     * @ORM\Column(name="magience_bonus", type="smallint")
     */
    private $magienceBonus;

    /**
     * @ORM\Column(name="magience_malus", type="smallint")
     */
    private $magienceMalus;

    /**
     * @ORM\Column(name="natural_environment", type="smallint")
     */
    private $naturalEnvironment;

    /**
     * @ORM\Column(name="natural_environment_bonus", type="smallint")
     */
    private $naturalEnvironmentBonus;

    /**
     * @ORM\Column(name="natural_environment_malus", type="smallint")
     */
    private $naturalEnvironmentMalus;

    /**
     * @ORM\Column(name="demorthen_mysteries", type="smallint")
     */
    private $demorthenMysteries;

    /**
     * @ORM\Column(name="demorthen_mysteries_bonus", type="smallint")
     */
    private $demorthenMysteriesBonus;

    /**
     * @ORM\Column(name="demorthen_mysteries_malus", type="smallint")
     */
    private $demorthenMysteriesMalus;

    /**
     * @ORM\Column(name="occultism", type="smallint")
     */
    private $occultism;

    /**
     * @ORM\Column(name="occultism_bonus", type="smallint")
     */
    private $occultismBonus;

    /**
     * @ORM\Column(name="occultism_malus", type="smallint")
     */
    private $occultismMalus;

    /**
     * @ORM\Column(name="perception", type="smallint")
     */
    private $perception;

    /**
     * @ORM\Column(name="perception_bonus", type="smallint")
     */
    private $perceptionBonus;

    /**
     * @ORM\Column(name="perception_malus", type="smallint")
     */
    private $perceptionMalus;

    /**
     * @ORM\Column(name="prayer", type="smallint")
     */
    private $prayer;

    /**
     * @ORM\Column(name="prayer_bonus", type="smallint")
     */
    private $prayerBonus;

    /**
     * @ORM\Column(name="prayer_malus", type="smallint")
     */
    private $prayerMalus;

    /**
     * @ORM\Column(name="feats", type="smallint")
     */
    private $feats;

    /**
     * @ORM\Column(name="feats_bonus", type="smallint")
     */
    private $featsBonus;

    /**
     * @ORM\Column(name="feats_malus", type="smallint")
     */
    private $featsMalus;

    /**
     * @ORM\Column(name="relation", type="smallint")
     */
    private $relation;

    /**
     * @ORM\Column(name="relation_bonus", type="smallint")
     */
    private $relationBonus;

    /**
     * @ORM\Column(name="relation_malus", type="smallint")
     */
    private $relationMalus;

    /**
     * @ORM\Column(name="performance", type="smallint")
     */
    private $performance;

    /**
     * @ORM\Column(name="performance_bonus", type="smallint")
     */
    private $performanceBonus;

    /**
     * @ORM\Column(name="performance_malus", type="smallint")
     */
    private $performanceMalus;

    /**
     * @ORM\Column(name="science", type="smallint")
     */
    private $science;

    /**
     * @ORM\Column(name="science_bonus", type="smallint")
     */
    private $scienceBonus;

    /**
     * @ORM\Column(name="science_malus", type="smallint")
     */
    private $scienceMalus;

    /**
     * @ORM\Column(name="shooting_and_throwing", type="smallint")
     */
    private $shootingAndThrowing;

    /**
     * @ORM\Column(name="shooting_and_throwing_bonus", type="smallint")
     */
    private $shootingAndThrowingBonus;

    /**
     * @ORM\Column(name="shooting_and_throwing_malus", type="smallint")
     */
    private $shootingAndThrowingMalus;

    /**
     * @ORM\Column(name="travel", type="smallint")
     */
    private $travel;

    /**
     * @ORM\Column(name="travel_bonus", type="smallint")
     */
    private $travelBonus;

    /**
     * @ORM\Column(name="travel_malus", type="smallint")
     */
    private $travelMalus;

    /**
     * @ORM\Column(name="erudition", type="smallint")
     */
    private $erudition;

    /**
     * @ORM\Column(name="erudition_bonus", type="smallint")
     */
    private $eruditionBonus;

    /**
     * @ORM\Column(name="erudition_malus", type="smallint")
     */
    private $eruditionMalus;

    public function __construct(
        int $craft,
        int $closeCombat,
        int $stealth,
        int $magience,
        int $naturalEnvironment,
        int $demorthenMysteries,
        int $occultism,
        int $perception,
        int $prayer,
        int $feats,
        int $relation,
        int $performance,
        int $science,
        int $shootingAndThrowing,
        int $travel,
        int $erudition
    ) {
        $this->craft = $craft;
        $this->closeCombat = $closeCombat;
        $this->stealth = $stealth;
        $this->magience = $magience;
        $this->naturalEnvironment = $naturalEnvironment;
        $this->demorthenMysteries = $demorthenMysteries;
        $this->occultism = $occultism;
        $this->perception = $perception;
        $this->prayer = $prayer;
        $this->feats = $feats;
        $this->relation = $relation;
        $this->performance = $performance;
        $this->science = $science;
        $this->shootingAndThrowing = $shootingAndThrowing;
        $this->travel = $travel;
        $this->erudition = $erudition;
    }

    //
    // Getters
    //

    public function getCraft(): int
    {
        return $this->craft;
    }

    public function getCraftBonus(): int
    {
        return $this->craftBonus;
    }

    public function getCraftMalus(): int
    {
        return $this->craftMalus;
    }

    public function getCloseCombat(): int
    {
        return $this->closeCombat;
    }

    public function getCloseCombatBonus(): int
    {
        return $this->closeCombatBonus;
    }

    public function getCloseCombatMalus(): int
    {
        return $this->closeCombatMalus;
    }

    public function getStealth(): int
    {
        return $this->stealth;
    }

    public function getStealthBonus(): int
    {
        return $this->stealthBonus;
    }

    public function getStealthMalus(): int
    {
        return $this->stealthMalus;
    }

    public function getMagience(): int
    {
        return $this->magience;
    }

    public function getMagienceBonus(): int
    {
        return $this->magienceBonus;
    }

    public function getMagienceMalus(): int
    {
        return $this->magienceMalus;
    }

    public function getNaturalEnvironment(): int
    {
        return $this->naturalEnvironment;
    }

    public function getNaturalEnvironmentBonus(): int
    {
        return $this->naturalEnvironmentBonus;
    }

    public function getNaturalEnvironmentMalus(): int
    {
        return $this->naturalEnvironmentMalus;
    }

    public function getDemorthenMysteries(): int
    {
        return $this->demorthenMysteries;
    }

    public function getDemorthenMysteriesBonus(): int
    {
        return $this->demorthenMysteriesBonus;
    }

    public function getDemorthenMysteriesMalus(): int
    {
        return $this->demorthenMysteriesMalus;
    }

    public function getOccultism(): int
    {
        return $this->occultism;
    }

    public function getOccultismBonus(): int
    {
        return $this->occultismBonus;
    }

    public function getOccultismMalus(): int
    {
        return $this->occultismMalus;
    }

    public function getPerception(): int
    {
        return $this->perception;
    }

    public function getPerceptionBonus(): int
    {
        return $this->perceptionBonus;
    }

    public function getPerceptionMalus(): int
    {
        return $this->perceptionMalus;
    }

    public function getPrayer(): int
    {
        return $this->prayer;
    }

    public function getPrayerBonus(): int
    {
        return $this->prayerBonus;
    }

    public function getPrayerMalus(): int
    {
        return $this->prayerMalus;
    }

    public function getFeats(): int
    {
        return $this->feats;
    }

    public function getFeatsBonus(): int
    {
        return $this->featsBonus;
    }

    public function getFeatsMalus(): int
    {
        return $this->featsMalus;
    }

    public function getRelation(): int
    {
        return $this->relation;
    }

    public function getRelationBonus(): int
    {
        return $this->relationBonus;
    }

    public function getRelationMalus(): int
    {
        return $this->relationMalus;
    }

    public function getPerformance(): int
    {
        return $this->performance;
    }

    public function getPerformanceBonus(): int
    {
        return $this->performanceBonus;
    }

    public function getPerformanceMalus(): int
    {
        return $this->performanceMalus;
    }

    public function getScience(): int
    {
        return $this->science;
    }

    public function getScienceBonus(): int
    {
        return $this->scienceBonus;
    }

    public function getScienceMalus(): int
    {
        return $this->scienceMalus;
    }

    public function getShootingAndThrowing(): int
    {
        return $this->shootingAndThrowing;
    }

    public function getShootingAndThrowingBonus(): int
    {
        return $this->shootingAndThrowingBonus;
    }

    public function getShootingAndThrowingMalus(): int
    {
        return $this->shootingAndThrowingMalus;
    }

    public function getTravel(): int
    {
        return $this->travel;
    }

    public function getTravelBonus(): int
    {
        return $this->travelBonus;
    }

    public function getTravelMalus(): int
    {
        return $this->travelMalus;
    }

    public function getErudition(): int
    {
        return $this->erudition;
    }

    public function getEruditionBonus(): int
    {
        return $this->eruditionBonus;
    }

    public function getEruditionMalus(): int
    {
        return $this->eruditionMalus;
    }

    //
    // Setters
    //

    public function setCraftBonus(int $craftBonus): void
    {
        $this->craftBonus = $craftBonus;
    }

    public function setCraftMalus(int $craftMalus): void
    {
        $this->craftMalus = $craftMalus;
    }

    public function setCloseCombatBonus(int $closeCombatBonus): void
    {
        $this->closeCombatBonus = $closeCombatBonus;
    }

    public function setCloseCombatMalus(int $closeCombatMalus): void
    {
        $this->closeCombatMalus = $closeCombatMalus;
    }

    public function setStealthBonus(int $stealthBonus): void
    {
        $this->stealthBonus = $stealthBonus;
    }

    public function setStealthMalus(int $stealthMalus): void
    {
        $this->stealthMalus = $stealthMalus;
    }

    public function setMagienceBonus(int $magienceBonus): void
    {
        $this->magienceBonus = $magienceBonus;
    }

    public function setMagienceMalus(int $magienceMalus): void
    {
        $this->magienceMalus = $magienceMalus;
    }

    public function setNaturalEnvironmentBonus(int $naturalEnvironmentBonus): void
    {
        $this->naturalEnvironmentBonus = $naturalEnvironmentBonus;
    }

    public function setNaturalEnvironmentMalus(int $naturalEnvironmentMalus): void
    {
        $this->naturalEnvironmentMalus = $naturalEnvironmentMalus;
    }

    public function setDemorthenMysteriesBonus(int $demorthenMysteriesBonus): void
    {
        $this->demorthenMysteriesBonus = $demorthenMysteriesBonus;
    }

    public function setDemorthenMysteriesMalus(int $demorthenMysteriesMalus): void
    {
        $this->demorthenMysteriesMalus = $demorthenMysteriesMalus;
    }

    public function setOccultismBonus(int $occultismBonus): void
    {
        $this->occultismBonus = $occultismBonus;
    }

    public function setOccultismMalus(int $occultismMalus): void
    {
        $this->occultismMalus = $occultismMalus;
    }

    public function setPerceptionBonus(int $perceptionBonus): void
    {
        $this->perceptionBonus = $perceptionBonus;
    }

    public function setPerceptionMalus(int $perceptionMalus): void
    {
        $this->perceptionMalus = $perceptionMalus;
    }

    public function setPrayerBonus(int $prayerBonus): void
    {
        $this->prayerBonus = $prayerBonus;
    }

    public function setPrayerMalus(int $prayerMalus): void
    {
        $this->prayerMalus = $prayerMalus;
    }

    public function setFeatsBonus(int $featsBonus): void
    {
        $this->featsBonus = $featsBonus;
    }

    public function setFeatsMalus(int $featsMalus): void
    {
        $this->featsMalus = $featsMalus;
    }

    public function setRelationBonus(int $relationBonus): void
    {
        $this->relationBonus = $relationBonus;
    }

    public function setRelationMalus(int $relationMalus): void
    {
        $this->relationMalus = $relationMalus;
    }

    public function setPerformanceBonus(int $performanceBonus): void
    {
        $this->performanceBonus = $performanceBonus;
    }

    public function setPerformanceMalus(int $performanceMalus): void
    {
        $this->performanceMalus = $performanceMalus;
    }

    public function setScienceBonus(int $scienceBonus): void
    {
        $this->scienceBonus = $scienceBonus;
    }

    public function setScienceMalus(int $scienceMalus): void
    {
        $this->scienceMalus = $scienceMalus;
    }

    public function setShootingAndThrowingBonus(int $shootingAndThrowingBonus): void
    {
        $this->shootingAndThrowingBonus = $shootingAndThrowingBonus;
    }

    public function setShootingAndThrowingMalus(int $shootingAndThrowingMalus): void
    {
        $this->shootingAndThrowingMalus = $shootingAndThrowingMalus;
    }

    public function setTravelBonus(int $travelBonus): void
    {
        $this->travelBonus = $travelBonus;
    }

    public function setTravelMalus(int $travelMalus): void
    {
        $this->travelMalus = $travelMalus;
    }

    public function setEruditionBonus(int $eruditionBonus): void
    {
        $this->eruditionBonus = $eruditionBonus;
    }

    public function setEruditionMalus(int $eruditionMalus): void
    {
        $this->eruditionMalus = $eruditionMalus;
    }

    public function setDomainValue(string $domain, int $value): void
    {
        DomainsData::validateDomainBaseValue($domain, $value);

        $propertyName = Inflector::camelize($domain);

        if (!isset($this->$propertyName)) {
            throw new InvalidDomain($domain);
        }

        $this->$propertyName = $value;
    }
}

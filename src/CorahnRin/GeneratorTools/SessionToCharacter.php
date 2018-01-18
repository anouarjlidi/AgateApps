<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\GeneratorTools;

use Behat\Transliterator\Transliterator;
use CorahnRin\Entity\Armors;
use CorahnRin\Entity\Avantages;
use CorahnRin\Entity\CharacterProperties\CharAdvantages;
use CorahnRin\Entity\CharacterProperties\CharDisciplines;
use CorahnRin\Entity\CharacterProperties\CharDomains;
use CorahnRin\Entity\CharacterProperties\CharSetbacks;
use CorahnRin\Entity\CharacterProperties\CharWays;
use CorahnRin\Entity\CharacterProperties\HealthCondition;
use CorahnRin\Entity\CharacterProperties\Money;
use CorahnRin\Entity\Characters;
use CorahnRin\Entity\CombatArts;
use CorahnRin\Entity\Disciplines;
use CorahnRin\Entity\Disorders;
use CorahnRin\Entity\Domains;
use CorahnRin\Entity\GeoEnvironments;
use CorahnRin\Entity\Jobs;
use CorahnRin\Entity\Peoples;
use CorahnRin\Entity\Setbacks;
use CorahnRin\Entity\SocialClasses;
use CorahnRin\Entity\Traits;
use CorahnRin\Entity\Ways;
use CorahnRin\Entity\Weapons;
use CorahnRin\Exception\CharactersException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityRepository;
use EsterenMaps\Entity\Zones;
use Orbitale\Component\DoctrineTools\EntityRepositoryHelperTrait;
use Pierstoval\Bundle\CharacterManagerBundle\Resolver\StepResolverInterface;

final class SessionToCharacter
{
    /**
     * @var Ways[]
     */
    private $ways;

    /**
     * @var Domains[]
     */
    private $domains;

    /**
     * @var Setbacks[]
     */
    private $setbacks;

    /**
     * @var Avantages[]
     */
    private $advantages;

    /**
     * @var EntityRepository[]
     */
    private $repositories;

    /**
     * @var StepResolverInterface
     */
    private $resolver;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var DomainsCalculator
     */
    private $domainsCalculator;

    public function __construct(StepResolverInterface $resolver, DomainsCalculator $domainsCalculator, ObjectManager $em)
    {
        $this->resolver          = $resolver;
        $this->em                = $em;
        $this->domainsCalculator = $domainsCalculator;
    }

    /**
     * @param array $values
     *
     * @throws CharactersException
     *
     * @return Characters
     */
    public function createCharacterFromGeneratorValues(array $values): Characters
    {
        $steps = $this->resolver->getSteps();

        $this->prepareNecessaryVariables();

        $generatorKeys = array_keys($values);
        $stepsKeys     = array_keys($steps);

        sort($generatorKeys);
        sort($stepsKeys);

        if ($generatorKeys !== $stepsKeys) {
            throw new CharactersException('Generator seems not to be fully finished');
        }

        $character = new Characters();

        $character->setCreated(new \DateTime());
        $this->setPeople($character, $values);
        $this->setJob($character, $values);
        $this->setBirthPlace($character, $values);
        $this->setGeoLiving($character, $values);
        $this->setSocialClass($character, $values);
        $this->setAge($character, $values);
        $this->setSetbacks($character, $values);
        $this->setWays($character, $values);
        $this->setTraits($character, $values);
        $this->setOrientation($character, $values);
        $this->setAdvantages($character, $values);
        $this->setMentalDisorder($character, $values);
        $this->setDisciplines($character, $values);
        $this->setCombatArts($character, $values);
        $this->setEquipment($character, $values);
        $this->setDescription($character, $values);
        $this->setExp($character, $values);
        $this->setMoney($character);
        $this->setDomains($character, $values);
        $this->setPrecalculatedValues($character);

        return $character;
    }

    /**
     * @param string $class
     *
     * @return EntityRepository|ObjectRepository|EntityRepositoryHelperTrait
     */
    private function getRepository($class)
    {
        if (isset($this->repositories[$class])) {
            return $this->repositories[$class];
        }

        return $this->repositories[$class] = $this->em->getRepository($class);
    }

    /**
     * Add some properties that will be used in other steps validators.
     * As a reminder, base repository is Orbitale's one, so using "_primary" will automatically index all objects by their id.
     */
    private function prepareNecessaryVariables(): void
    {
        $this->ways       = $this->getRepository(Ways::class)->findAll();
        $this->setbacks   = $this->getRepository(Setbacks::class)->findAll('_primary');
        $this->domains    = $this->getRepository(Domains::class)->findAll('_primary');
        $this->advantages = $this->getRepository(Avantages::class)->findAll('_primary');
    }

    private function setPeople(Characters $character, array $values): void
    {
        $character->setPeople($this->getRepository(Peoples::class)->find($values['01_people']));
    }

    private function setJob(Characters $character, array $values): void
    {
        $character->setJob($this->getRepository(Jobs::class)->find($values['02_job']));
    }

    private function setBirthPlace(Characters $character, array $values): void
    {
        $character->setBirthPlace($this->getRepository(Zones::class)->find($values['03_birthplace']));
    }

    private function setGeoLiving(Characters $character, array $values): void
    {
        $character->setGeoLiving($this->getRepository(GeoEnvironments::class)->find($values['04_geo']));
    }

    private function setSocialClass(Characters $character, array $values): void
    {
        $character->setSocialClass($this->getRepository(SocialClasses::class)->find($values['05_social_class']['id']));

        $domains = $values['05_social_class']['domains'];
        reset($domains);
        $character->setSocialClassDomain1($this->domains[current($domains)]);
        $character->setSocialClassDomain2($this->domains[next($domains)]);
    }

    private function setAge(Characters $character, array $values): void
    {
        $character->setAge($values['06_age']);
    }

    private function setSetbacks(Characters $character, array $values): void
    {
        foreach ($values['07_setbacks'] as $id => $details) {
            $charSetback = new CharSetbacks();
            $charSetback->setCharacter($character);
            $charSetback->setSetback($this->setbacks[$id]);
            $charSetback->setAvoided($details['avoided']);
            $character->addSetback($charSetback);
        }
    }

    private function setWays(Characters $character, array $values): void
    {
        foreach ($this->ways as $way) {
            $charWay = new CharWays($character, $way, $values['08_ways'][$way->getId()]);
            $character->addWay($charWay);
        }
    }

    private function setTraits(Characters $character, array $values): void
    {
        $character->setQuality($this->getRepository(Traits::class)->find($values['09_traits']['quality']));
        $character->setFlaw($this->getRepository(Traits::class)->find($values['09_traits']['flaw']));
    }

    private function setOrientation(Characters $character, array $values): void
    {
        $character->setOrientation($values['10_orientation']);
    }

    private function setAdvantages(Characters $character, array $values): void
    {
        foreach ($values['11_advantages']['advantages'] as $id => $value) {
            if (!$value) {
                continue;
            }
            $charAdvantage = new CharAdvantages();
            $charAdvantage->setCharacter($character);
            $charAdvantage->setAdvantage($this->advantages[$id]);
            $charAdvantage->setScore($value);
            $character->addCharAdvantage($charAdvantage);
        }

        foreach ($values['11_advantages']['disadvantages'] as $id => $value) {
            if (!$value) {
                continue;
            }
            $charAdvantage = new CharAdvantages();
            $charAdvantage->setCharacter($character);
            $charAdvantage->setAdvantage($this->advantages[$id]);
            $charAdvantage->setScore($value);
            $character->addCharAdvantage($charAdvantage);
        }
    }

    private function setMentalDisorder(Characters $character, array $values): void
    {
        $character->setMentalDisorder($this->getRepository(Disorders::class)->find($values['12_mental_disorder']));
    }

    private function setDisciplines(Characters $character, array $values): void
    {
        foreach ($values['16_disciplines']['disciplines'] as $domainId => $disciplines) {
            foreach ($disciplines as $id => $v) {
                $charDiscipline = new CharDisciplines();
                $charDiscipline->setCharacter($character);
                $charDiscipline->setScore(6);
                $charDiscipline->setDomain($this->domains[$domainId]);
                $charDiscipline->setDiscipline($this->getRepository(Disciplines::class)->find($id));
                $character->addDiscipline($charDiscipline);
            }
        }
    }

    private function setCombatArts(Characters $character, array $values): void
    {
        foreach ($values['17_combat_arts']['combatArts'] as $id => $v) {
            $character->addCombatArt($this->getRepository(CombatArts::class)->find($id));
        }
    }

    private function setEquipment(Characters $character, array $values): void
    {
        $character->setInventory($values['18_equipment']['equipment']);

        foreach ($values['18_equipment']['armors'] as $id => $value) {
            $character->addArmor($this->getRepository(Armors::class)->find($id));
        }
        foreach ($values['18_equipment']['weapons'] as $id => $value) {
            $character->addWeapon($this->getRepository(Weapons::class)->find($id));
        }
    }

    private function setDescription(Characters $character, array $values): void
    {
        $details = $values['19_description'];
        $character->setName($details['name']);
        $character->setPlayerName($details['player_name']);
        $character->setSex($details['sex']);
        $character->setDescription($details['description']);
        $character->setStory($details['story']);
        $character->setFacts($details['facts']);

        // Make sure slug is unique by just adding a number to it
        $charRepo = $this->getRepository(Characters::class);

        $i = 0;
        do {
            $slug = Transliterator::transliterate($details['name']).($i ? '_'.$i : '');
            $i++;
        } while ($charRepo->findOneBy(['nameSlug' => $slug]));
        $character->setNameSlug($slug);
    }

    private function setExp(Characters $character, array $values): void
    {
        $character->setExperienceActual((int) $values['17_combat_arts']['remainingExp']);
        $character->setExperienceSpent(0);
    }

    private function setMoney(Characters $character): void
    {
        $money = new Money();

        $salary = $character->getJob()->getDailySalary();
        if ($salary > 0) {
            if (!$character->hasSetback(9)) {
                // Use salary only if job defines one AND character is not poor
                $money->addEmber(30 * $salary);
                $money->reallocate();
            }
        } else {
            // If salary is not set in job, character has 2d10 azure daols
            $azure = random_int(1, 10) + random_int(1, 10);
            if ($character->hasSetback(9)) {
                // If character is poor, he has half money
                $azure = (int) floor($azure / 2);
            }
            $money->addAzure($azure);
            $money->reallocate();
        }

        $character->setMoney($money);
    }

    private function setDomains(Characters $character, array $values): void
    {
        $domainsBaseValues = $this->domainsCalculator->calculateFromGeneratorData(
            $this->domains,
            $values['05_social_class']['domains'],
            $values['13_primary_domains']['ost'],
            $values['13_primary_domains']['scholar'] ?: null,
            $character->getGeoLiving(),
            $values['13_primary_domains']['domains'],
            $values['14_use_domain_bonuses']['domains']
        );

        $finalDomainsValues = $this->domainsCalculator->calculateFinalValues(
            $this->domains,
            $domainsBaseValues,
            array_map(function ($e) { return (int) $e; }, $values['15_domains_spend_exp']['domains'])
        );

        $bonuses = array_fill_keys(array_keys($this->domains), 0);
        $maluses = array_fill_keys(array_keys($this->domains), 0);

        $health = new HealthCondition();

        foreach ($character->getCharAdvantages() as $charAdvantage) {
            $adv = $charAdvantage->getAdvantage();
            if (!trim($adv->getBonusdisc())) {
                continue;
            }
            $bonusDiscs = preg_split('~,~', $adv->getBonusdisc(), -1, PREG_SPLIT_NO_EMPTY);
            foreach ($bonusDiscs as $bonus) {
                if (isset($this->domains[$bonus])) {
                    if ($adv->isDesv()) {
                        $maluses[$bonus] += $charAdvantage->getScore();
                    } else {
                        $bonuses[$bonus] += $charAdvantage->getScore();
                    }
                } else {
                    $disadvantageRatio = $adv->isDesv() ? -1 : 1;
                    switch ($bonus) {
                        case Avantages::BONUS_RESM:
                            $character->setMentalResistBonus($character->getMentalResistBonus() + ($charAdvantage->getScore() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_BLESS:
                            $score = $charAdvantage->getScore();
                            switch (true) {
                                case $score >= 1:
                                    $health->setBad($health->getBad() + 1);
                                case $score >= 2:
                                    $health->setCritical($health->getCritical() + 1);
                                    break;
                                case $score <= -1:
                                    $health->setOkay($health->getOkay() - 1);
                                case $score <= -2:
                                    $health->setCritical($health->getCritical() - 1);
                                    break;
                            }
                            break;
                        case Avantages::BONUS_VIG:
                            $character->setStamina($character->getStamina() + ($charAdvantage->getScore() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_TRAU:
                            $character->setTraumaPermanent($character->getTraumaPermanent() + $charAdvantage->getScore());
                            break;
                        case Avantages::BONUS_DEF:
                            $character->setDefenseBonus($character->getDefenseBonus() + ($charAdvantage->getScore() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_RAP:
                            $character->setSpeedBonus($character->getSpeedBonus() + ($charAdvantage->getScore() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_SUR:
                            $character->setSurvival($character->getSurvival() + ($charAdvantage->getScore() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_100G:
                            $character->getMoney()->addFrost(100);
                            break;
                        case Avantages::BONUS_20G:
                            $character->getMoney()->addFrost(20);
                            break;
                        case Avantages::BONUS_50G:
                            $character->getMoney()->addFrost(50);
                            break;
                        case Avantages::BONUS_50A:
                            $character->getMoney()->addAzure(50);
                            break;
                        case Avantages::BONUS_20A:
                            $character->getMoney()->addAzure(20);
                            break;
                        default:
                            throw new \RuntimeException("Invalid bonus $bonus");
                    }
                }
            }
        }

        $character->setHealth($health);
        $character->setMaxHealth(clone $health);

        foreach ($finalDomainsValues as $id => $value) {
            $charDomain = new CharDomains();
            $charDomain->setCharacter($character);
            $charDomain->setDomain($this->domains[$id]);
            $charDomain->setScore($value);
            $charDomain->setBonus($bonuses[$id]);
            $charDomain->setMalus($maluses[$id]);
            $character->addDomain($charDomain);
        }
    }

    private function setPrecalculatedValues(Characters $character): void
    {
        // Rindath
        $rindathMax =
            $character->getWay(1)->getScore()
            + $character->getWay(2)->getScore()
            + $character->getWay(3)->getScore()
        ;
        if ($sigilRann = $character->getDiscipline('Sigil Rann')) {
            $rindathMax += (($sigilRann->getScore() - 5) * 5);
        }
        $character->setRindathMax($rindathMax);
        $character->setRindath($rindathMax);

        // Exaltation
        $exaltationMax = $character->getWay(5)->getScore() * 3;
        if ($miracles = $character->getDiscipline('Miracles')) {
            $exaltationMax += (($miracles->getScore() - 5) * 5);
        }
        $character->setExaltationMax($exaltationMax);
        $character->setExaltation($exaltationMax);
    }
}

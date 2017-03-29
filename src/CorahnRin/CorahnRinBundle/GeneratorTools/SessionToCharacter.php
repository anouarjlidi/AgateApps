<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\GeneratorTools;

use Behat\Transliterator\Transliterator;
use CorahnRin\CorahnRinBundle\Entity\Avantages;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharAdvantages;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDisciplines;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharDomains;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharSetbacks;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharWays;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\Money;
use CorahnRin\CorahnRinBundle\Entity\Characters;
use CorahnRin\CorahnRinBundle\Entity\Domains;
use CorahnRin\CorahnRinBundle\Entity\Setbacks;
use CorahnRin\CorahnRinBundle\Entity\Ways;
use CorahnRin\CorahnRinBundle\Exception\CharactersException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use Pierstoval\Bundle\CharacterManagerBundle\Resolver\StepActionResolver;

final class SessionToCharacter
{
    /**
     * @var Ways[]
     */
    protected $ways;

    /**
     * @var Domains[]
     */
    protected $domains;

    /**
     * @var Setbacks[]
     */
    protected $setbacks;

    /**
     * @var Avantages[]
     */
    protected $advantages;

    /**
     * @var BaseEntityRepository[]
     */
    private $repositories;

    /**
     * @var StepActionResolver
     */
    private $resolver;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var DomainsCalculator
     */
    private $domainsCalculator;

    public function __construct(StepActionResolver $resolver, DomainsCalculator $domainsCalculator, EntityManager $em)
    {
        $this->resolver = $resolver;
        $this->em = $em;
        $this->domainsCalculator = $domainsCalculator;
    }

    /**
     * @param array $values
     *
     * @throws CharactersException
     *
     * @return Characters
     */
    public function createCharacterFromGeneratorValues(array $values)
    {
        $steps = $this->resolver->getSteps();

        $this->prepareNecessaryVariables();

        $generatorKeys = array_keys($values);
        $stepsKeys = array_keys($steps);

        sort($generatorKeys);
        sort($stepsKeys);

        if ($generatorKeys !== $stepsKeys) {
            throw new CharactersException('Generator seems not to be fully finished');
        }

        $character = new Characters();

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
        $this->setMoney($character, $values);
        $this->setDomains($character, $values);
        $this->setPrecalculatedValues($character, $values);

        return $character;
    }

    /**
     * @param string $class
     *
     * @return BaseEntityRepository|EntityRepository
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
    private function prepareNecessaryVariables()
    {
        $this->ways = $this->getRepository('CorahnRinBundle:Ways')->findAll();
        $this->setbacks = $this->getRepository('CorahnRinBundle:Setbacks')->findAll('_primary');
        $this->domains = $this->getRepository('CorahnRinBundle:Domains')->findAll('_primary');
        $this->advantages = $this->getRepository('CorahnRinBundle:Avantages')->findAll('_primary');
    }

    private function setPeople(Characters $character, array $values)
    {
        $character->setPeople($this->getRepository('CorahnRinBundle:Peoples')->find($values['01_people']));
    }

    private function setJob(Characters $character, array $values)
    {
        $character->setJob($this->getRepository('CorahnRinBundle:Jobs')->find($values['02_job']));
    }

    private function setBirthPlace(Characters $character, array $values)
    {
        $character->setBirthPlace($this->getRepository('EsterenMapsBundle:Zones')->find($values['03_birthplace']));
    }

    private function setGeoLiving(Characters $character, array $values)
    {
        $character->setGeoLiving($this->getRepository('CorahnRinBundle:GeoEnvironments')->find($values['04_geo']));
    }

    private function setSocialClass(Characters $character, array $values)
    {
        $character->setSocialClass($this->getRepository('CorahnRinBundle:SocialClasses')->find($values['05_social_class']['id']));

        $domains = $values['05_social_class']['domains'];
        reset($domains);
        $character->setSocialClassDomain1($this->domains[current($domains)]);
        $character->setSocialClassDomain2($this->domains[next($domains)]);
    }

    private function setAge(Characters $character, array $values)
    {
        $character->setAge($values['06_age']);
    }

    private function setSetbacks(Characters $character, array $values)
    {
        foreach ($values['07_setbacks'] as $id => $details) {
            $charSetback = new CharSetbacks();
            $charSetback->setCharacter($character);
            $charSetback->setSetback($this->setbacks[$id]);
            $charSetback->setIsAvoided($details['avoided']);
            $character->addSetback($charSetback);
        }
    }

    private function setWays(Characters $character, array $values)
    {
        foreach ($this->ways as $way) {
            $charWay = new CharWays($character, $way, $values['08_ways'][$way->getId()]);
            $character->addWay($charWay);
        }
    }

    private function setTraits(Characters $character, array $values)
    {
        $character->setQuality($this->getRepository('CorahnRinBundle:Traits')->find($values['09_traits']['quality']));
        $character->setFlaw($this->getRepository('CorahnRinBundle:Traits')->find($values['09_traits']['flaw']));
    }

    private function setOrientation(Characters $character, array $values)
    {
        $character->setOrientation($values['10_orientation']);
    }

    private function setAdvantages(Characters $character, array $values)
    {
        foreach ($values['11_advantages']['advantages'] as $id => $value) {
            if (!$value) {
                continue;
            }
            $charAdvantage = new CharAdvantages();
            $charAdvantage->setCharacter($character);
            $charAdvantage->setAdvantage($this->advantages[$id]);
            $charAdvantage->setValue($value);
            $character->addAdvantage($charAdvantage);
        }

        foreach ($values['11_advantages']['disadvantages'] as $id => $value) {
            if (!$value) {
                continue;
            }
            $charAdvantage = new CharAdvantages();
            $charAdvantage->setCharacter($character);
            $charAdvantage->setAdvantage($this->advantages[$id]);
            $charAdvantage->setValue($value);
            $character->addAdvantage($charAdvantage);
        }
    }

    private function setMentalDisorder(Characters $character, array $values)
    {
        $character->setMentalDisorder($this->getRepository('CorahnRinBundle:Disorders')->find($values['12_mental_disorder']));
    }

    private function setDisciplines(Characters $character, array $values)
    {
        foreach ($values['16_disciplines']['disciplines'] as $domainId => $disciplines) {
            foreach ($disciplines as $id => $v) {
                $charDiscipline = new CharDisciplines();
                $charDiscipline->setCharacter($character);
                $charDiscipline->setScore(6);
                $charDiscipline->setDomain($this->domains[$domainId]);
                $charDiscipline->setDiscipline($this->getRepository('CorahnRinBundle:Disciplines')->find($id));
                $character->addDiscipline($charDiscipline);
            }
        }
    }

    private function setCombatArts(Characters $character, array $values)
    {
        foreach ($values['17_combat_arts']['combatArts'] as $id => $v) {
            $character->addCombatArt($this->getRepository('CorahnRinBundle:CombatArts')->find($id));
        }
    }

    private function setEquipment(Characters $character, array $values)
    {
        $character->setInventory($values['18_equipment']['equipment']);

        foreach ($values['18_equipment']['armors'] as $id => $value) {
            $character->addArmor($this->getRepository('CorahnRinBundle:Armors')->find($id));
        }
        foreach ($values['18_equipment']['weapons'] as $id => $value) {
            $character->addWeapon($this->getRepository('CorahnRinBundle:Weapons')->find($id));
        }
    }

    private function setDescription(Characters $character, array $values)
    {
        $details = $values['19_description'];
        $character->setName($details['name']);
        $character->setPlayerName($details['player_name']);
        $character->setSex($details['sex']);
        $character->setDescription($details['description']);
        $character->setStory($details['story']);
        $character->setFacts($details['facts']);

        // Make sure slug is unique by just adding a number to it
        $charRepo = $this->getRepository('CorahnRinBundle:Characters');
        $i = 0;
        do {
            $slug = Transliterator::transliterate($details['name']).($i ? '_'.$i : '');
            $i++;
        } while ($charRepo->findOneBy(['nameSlug' => $slug]));
        $character->setNameSlug($slug);
    }

    private function setExp(Characters $character, array $values)
    {
        $character->setExperienceActual((int) $values['17_combat_arts']['remainingExp']);
        $character->setExperienceSpent(0);
    }

    private function setMoney(Characters $character, array $values)
    {
        $money = new Money();

        //TODO: Manage "poor" disadvantage

        $character->setMoney($money);
    }

    private function setDomains(Characters $character, array $values)
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
            array_map(function($e) { return (int) $e; }, $values['15_domains_spend_exp']['domains'])
        );

        $bonuses = array_fill_keys(array_keys($this->domains), 0);
        $maluses = array_fill_keys(array_keys($this->domains), 0);

        foreach ($character->getAdvantages() as $charAdvantage) {
            $adv = $charAdvantage->getAdvantage();
            if (!trim($adv->getBonusdisc())) {
                continue;
            }
            $bonusDiscs = explode(',', $adv->getBonusdisc());
            dump($adv->getBonusdisc());
            foreach ($bonusDiscs as $bonus) {
                if (!$bonus) {
                    continue;
                }
                if (isset($this->domains[$bonus])) {
                    if ($adv->getIsDesv()) {
                        $maluses[$bonus] += $charAdvantage->getValue();
                    } else {
                        $bonuses[$bonus] += $charAdvantage->getValue();
                    }
                } else {
                    $disadvantageRatio = $adv->getIsDesv() ? -1 : 1;
                    switch ($bonus) {
                        case Avantages::BONUS_RESM;
                            $character->setMentalResistBonus($character->getMentalResistBonus() + ($charAdvantage->getValue() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_BLESS:
                            $character->setMaxHealth($character->getMaxHealth() + ($charAdvantage->getValue() * $disadvantageRatio));
                            $character->setHealth($character->getHealth() + ($charAdvantage->getValue() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_VIG;
                            $character->setStamina($character->getStamina() + ($charAdvantage->getValue() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_TRAU:
                            $character->setTrauma($character->getTrauma() + $charAdvantage->getValue());
                            break;
                        case Avantages::BONUS_DEF;
                            $character->setDefenseBonus($character->getDefenseBonus() + ($charAdvantage->getValue() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_RAP;
                            $character->setSpeedBonus($character->getSpeedBonus() + ($charAdvantage->getValue() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_SUR;
                            $character->setSurvival($character->getSurvival() + ($charAdvantage->getValue() * $disadvantageRatio));
                            break;
                        case Avantages::BONUS_100G;
                            $character->getMoney()->addFrost(100);
                            break;
                        case Avantages::BONUS_20G;
                            $character->getMoney()->addFrost(20);
                            break;
                        case Avantages::BONUS_50G;
                            $character->getMoney()->addFrost(50);
                            break;
                        case Avantages::BONUS_50A;
                            $character->getMoney()->addAzure(50);
                            break;
                        case Avantages::BONUS_20A;
                            $character->getMoney()->addAzure(20);
                            break;
                        default:
                            throw new \RuntimeException("Invalid bonus $bonus");
                    }
                }
            }
        }

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

    private function setPrecalculatedValues(Characters $character, array $values)
    {
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

        $exaltationMax = $character->getWay(5)->getScore() * 3;
        if ($miracles = $character->getDiscipline('Miracles')) {
            $exaltationMax += (($miracles->getScore() - 5) * 5);
        }
        $character->setExaltationMax($exaltationMax);
        $character->setExaltation($exaltationMax);
    }
}

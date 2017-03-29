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
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharSetbacks;
use CorahnRin\CorahnRinBundle\Entity\CharacterProperties\CharWays;
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

    public function __construct(StepActionResolver $resolver, EntityManager $em)
    {
        $this->resolver = $resolver;
        $this->em = $em;
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

    private function setDomains($character, $values)
    {
        // TODO
    }

    private function setPrecalculatedValues($character, $values)
    {
        // TODO
    }
}

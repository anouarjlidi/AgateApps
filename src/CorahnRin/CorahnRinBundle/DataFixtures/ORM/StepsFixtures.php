<?php

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Steps;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class StepsFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        /** @var EntityRepository $repo */
        $repo = $this->manager->getRepository('CorahnRinBundle:Steps');

        $this->fixtureObject($repo, 20, 20, 'finalisation', 'Finalisation du personnage', array());
        $this->fixtureObject($repo, 19, 19, 'description_histoire', 'Description et histoire', array());
        $this->fixtureObject($repo, 18, 18, 'equipements', 'Équipements', array());
        $this->fixtureObject($repo, 17, 17, 'arts_combat', 'Arts de combat', array());
        $this->fixtureObject($repo, 16, 16, 'disciplines', 'Disciplines', array(17));
        $this->fixtureObject($repo, 15, 15, 'bonusdom', 'Bonus divers ajoutés aux domaines', array(16, 17));
        $this->fixtureObject($repo, 14, 14, 'domaines_amelio', 'Amélioration des domaines', array(15, 16, 17));
        $this->fixtureObject($repo, 13, 13, 'domaines_primsec', 'Domaines primaires et secondaires', array(14, 15, 16, 17));
        $this->fixtureObject($repo, 12, 12, 'sante_mentale', 'Santé Mentale', array());
        $this->fixtureObject($repo, 11, 11, 'des_avtg', 'Avantages et Désavantages', array(13, 14, 15, 16, 17));
        $this->fixtureObject($repo, 10, 10, 'orientation', 'Orientation de la personnalité', array());
        $this->fixtureObject($repo, 9, 9, 'traits', 'Traits de caractère', array());
        $this->fixtureObject($repo, 8, 8, 'voies', 'Voies', array(9, 10, 12));
        $this->fixtureObject($repo, 7, 7, 'revers', 'Revers', array());
        $this->fixtureObject($repo, 6, 6, 'age', 'Âge', array(7));
        $this->fixtureObject($repo, 5, 5, 'classe', 'Classe sociale', array(13, 14, 15, 16, 17));
        $this->fixtureObject($repo, 4, 4, 'geo', 'Lieu de résidence géographique', array(13, 14, 15, 16, 17));
        $this->fixtureObject($repo, 3, 3, 'naissance', 'Lieu de naissance', array());
        $this->fixtureObject($repo, 2, 2, 'metier', 'Métier', array(13, 14, 15, 16, 17));
        $this->fixtureObject($repo, 1, 1, 'peuple', 'Peuple', array());

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $step, $slug, $title, $stepsToDisable = array())
    {
        $obj = null;
        $newObject = false;
        $addRef = false;
        if ($id) {
            $obj = $repo->find($id);
            if ($obj) {
                $addRef = true;
            } else {
                $newObject = true;
            }
        } else {
            $newObject = true;
        }
        if ($newObject === true) {
            $obj = new Steps();
            $obj->setId($id)
                ->setStep($step)
                ->setSlug($slug)
                ->setTitle($title)
            ;
            foreach ($stepsToDisable as $stepToDisableId) {
                /** @var Steps $stepToDisable */
                $stepToDisable = $this->getReference('corahnrin-step-'.$stepToDisableId);
                $obj->addStepToDisableOnChange($stepToDisable);
            }
            if ($id) {
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('corahnrin-step-'.$id, $obj);
        }
    }
}

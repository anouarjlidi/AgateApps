<?php

namespace CorahnRin\ModelsBundle\DataFixtures\ORM;

use CorahnRin\ModelsBundle\Entity\Setbacks;
use CorahnRin\ModelsBundle\Entity\Books;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class SetbacksFixtures extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * Get the order of this fixture
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('CorahnRinModelsBundle:Setbacks');

        /** @var Books $book */
        $book = $this->getReference('corahnrin-book-2');

        $this->fixtureObject($repo, 1, 'Poisse', 'Tirer une deuxième fois, ignorer les 1 supplémentaires', '', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);
        $this->fixtureObject($repo, 2, 'Séquelle', '-1 Vigueur, et une séquelle physique (cicatrice...)', 'vig', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);
        $this->fixtureObject($repo, 3, 'Adversaire', 'Le personnage s\'est fait un ennemi (à la discrétion du MJ)', '', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);
        $this->fixtureObject($repo, 4, 'Rumeur', 'Une information, vraie ou non, circule à propos du personnage', '', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);
        $this->fixtureObject($repo, 5, 'Amour tragique', '+1 point de Trauma définitif, mauvais souvenir', 'trauma', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);
        $this->fixtureObject($repo, 6, 'Maladie', '-1 Vigueur, mais a survécu à une maladie normalement mortelle', 'vig', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);
        $this->fixtureObject($repo, 7, 'Violence', '+1 point de Trauma définitif, souvenir violent, gore, horrible...', 'trauma', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);
        $this->fixtureObject($repo, 8, 'Solitude', 'Les proches, amis ou famille du personnage sont morts de façon douteuse', '', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);
        $this->fixtureObject($repo, 9, 'Pauvreté', 'Le personnage ne possède qu\'une mauvaise arme, ou outil, a des dettes d\'héritage, de vol... Il n\'a plus d\'argent, sa famille a été ruinée ou lui-même est ruiné d\'une façon ou d\'une autre, et aucun évènement ou avantage ne peut y remédier.', '0g', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);
        $this->fixtureObject($repo, 10, 'Chance', 'Le personnage est passé à côté de la catastrophe !', '', '2014-04-09 08:57:25', '2014-04-09 08:57:25', null,$book);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $malus, $created, $updated, $deleted = null,  $book)
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
            $obj = new Setbacks();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setBook($book)
                ->setMalus($malus)
                ->setCreated($created ? new \Datetime($created) : new \Datetime())
                ->setUpdated($updated ? new \Datetime($updated) : null)
                ->setDeleted($deleted ? new \Datetime($deleted) : null)
            ;
            if ($id) {
                /** @var ClassMetadata $metadata */
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('corahnrin-setback-'.$id, $obj);
        }
    }
}
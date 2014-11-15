<?php

namespace CorahnRin\ModelsBundle\DataFixtures\ORM;

use CorahnRin\ModelsBundle\Entity\Domains;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class DomainsFixtures extends AbstractFixture implements OrderedFixtureInterface {

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
        return 3;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('CorahnRinModelsBundle:Domains');

        $way1 = $this->getReference('corahnrin-way-1');
        $way2 = $this->getReference('corahnrin-way-2');
        $way3 = $this->getReference('corahnrin-way-3');
        $way4 = $this->getReference('corahnrin-way-4');
        $way5 = $this->getReference('corahnrin-way-5');

        $this->fixtureObject($repo, 1, $way2, 'Artisanat', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 2, $way1, 'Combat au Contact', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 3, $way3, 'Discrétion', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 4, $way4, 'Magience', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 5, $way3, 'Milieu Naturel', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 6, $way3, 'Mystères Demorthèn', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 7, $way4, 'Occultisme', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 8, $way4, 'Perception', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 9, $way5, 'Prière', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 10, $way1, 'Prouesses', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 11, $way3, 'Relation', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 12, $way2, 'Représentation', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 13, $way4, 'Science', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 14, $way1, 'Tir et Lancer', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 15, $way3, 'Voyage', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 16, $way4, 'Érudition', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $way, $name, $description, $created, $updated, $deleted = null)
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
            $obj = new Domains();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setWay($way)
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
            $this->addReference('corahnrin-domain-'.$id, $obj);
        }
    }
}
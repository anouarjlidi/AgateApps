<?php

namespace CorahnRin\ModelsBundle\DataFixtures\ORM;

use CorahnRin\ModelsBundle\Entity\Flux;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

class LoadFluxData extends AbstractFixture implements OrderedFixtureInterface {

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

        $repo = $this->manager->getRepository('CorahnRinModelsBundle:Flux');

        $this->fixtureObject($repo, 1, 'Végétal', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 2, 'Minéral', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 3, 'Organique', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 4, 'Fossile', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 5, 'M', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $created, $updated, $deleted = null)
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
            $obj = new Flux();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setCreated($created ? new \Datetime($created) : new \Datetime())
                ->setUpdated($updated ? new \Datetime($updated) : null)
                ->setDeleted($deleted ? new \Datetime($deleted) : null)
            ;
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('corahnrin-flux-'.$id, $obj);
        }
    }
}
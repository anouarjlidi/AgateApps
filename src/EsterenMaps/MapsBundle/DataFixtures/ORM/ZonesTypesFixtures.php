<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\ZonesTypes;

class ZonesTypesFixtures extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ZonesTypes[]
     */
    private $zonesTypes = array();

    /**
     * Get the order of this fixture
     * @return integer
     */
    function getOrder()
    {
        return 0;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:ZonesTypes');

        $this->fixtureObject($repo, 1, null, 'Politique', '', '', '2014-07-06 19:43:13', '2014-07-06 19:43:13', null);
        $this->fixtureObject($repo, 2, 1, 'Royaume', '', '', '2014-07-06 19:45:31', '2014-07-06 19:45:31', null);
        $this->fixtureObject($repo, 3, 1, 'Territoire', '', '', '2014-07-06 19:45:52', '2014-07-06 19:45:52', null);
        $this->fixtureObject($repo, 4, 1, 'Domaine', '', '', '2014-07-06 19:46:04', '2014-07-06 19:46:04', null);
        $this->fixtureObject($repo, 5, 1, 'Ville / Village', '', '', '2014-07-06 19:46:10', '2014-07-06 19:46:10', null);
        $this->fixtureObject($repo, 6, 1, 'Terre sacrée', '', '', '2014-07-06 19:46:29', '2014-07-06 19:46:29', null);
        $this->fixtureObject($repo, 7, null, 'Terrain', '', '', '2014-07-06 19:47:19', '2014-07-06 19:47:19', null);
        $this->fixtureObject($repo, 8, 7, 'Forêt', '', '', '2014-07-06 19:47:41', '2014-07-06 19:47:41', null);
        $this->fixtureObject($repo, 9, 7, 'Marais', '', '', '2014-07-06 19:47:46', '2014-07-06 19:47:46', null);
        $this->fixtureObject($repo, 10, 7, 'Montagnes', '', '', '2014-07-06 19:47:54', '2014-07-06 19:47:54', null);
        $this->fixtureObject($repo, 11, 7, 'Failles / Falaises', '', '', '2014-07-06 19:48:03', '2014-07-06 19:48:03', null);
        $this->fixtureObject($repo, 12, 7, 'Landes', '', '', '2014-07-06 19:48:08', '2014-07-06 19:48:08', null);
        $this->fixtureObject($repo, 13, 7, 'Mer', '', '', '2014-07-06 19:55:44', '2014-07-06 19:55:44', null);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $parent, $name, $description, $color, $created, $updated, $deleted = null)
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
            $obj = new ZonesTypes();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setColor($color)
                ->setCreated($created ? new \Datetime($created) : new \Datetime())
                ->setUpdated($updated ? new \Datetime($updated) : null)
                ->setDeleted($deleted ? new \Datetime($deleted) : null)
            ;
            if ($parent) {
                if (!isset($this->zonesTypes[$parent])) {
                    $this->zonesTypes[$parent] = $this->getReference('esterenmaps-zonestypes-'.$parent);
                }
                $obj->setParent($this->zonesTypes[$parent]);
            }
            if ($id) {
                /** @var ClassMetadata $metadata */
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('esterenmaps-zonestypes-'.$id, $obj);
        }
    }
}
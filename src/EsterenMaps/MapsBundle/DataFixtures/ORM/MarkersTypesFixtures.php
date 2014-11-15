<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\MarkersTypes;

class MarkersTypesFixtures extends AbstractFixture implements OrderedFixtureInterface {

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
        return 0;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:MarkersTypes');

        $this->fixtureObject($repo, 1, 'Cité', '', '', '2014-04-09 09:20:37', '2014-05-08 16:19:26', null);
        $this->fixtureObject($repo, 2, 'Port (village côtier, ...)', '', '', '2014-05-08 16:19:19', '2014-05-10 17:20:31', null);
        $this->fixtureObject($repo, 3, 'Carrefour', '', '', '2014-05-08 16:22:17', '2014-05-08 16:22:17', null);
        $this->fixtureObject($repo, 4, 'Sanctuaire', '', '', '2014-05-10 16:51:00', '2014-05-10 16:51:00', null);
        $this->fixtureObject($repo, 5, 'Site d\'intérêt', '', '', '2014-05-10 17:13:47', '2014-05-10 17:13:47', null);
        $this->fixtureObject($repo, 6, 'Fortifications (châteaux, angardes, rosace)', '', '', '2014-05-10 17:17:38', '2014-05-10 17:18:47', null);
        $this->fixtureObject($repo, 7, 'Souterrain (mine, cité troglodyte, réseau de cavernes)', '', '', '2014-05-10 17:21:40', '2014-05-10 17:21:40', null);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $icon, $created, $updated, $deleted = null)
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
            $obj = new MarkersTypes();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setIconName($icon)
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
            $this->addReference('esterenmaps-markerstypes-'.$id, $obj);
        }
    }
}
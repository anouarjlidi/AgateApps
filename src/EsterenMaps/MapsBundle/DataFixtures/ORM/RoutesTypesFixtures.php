<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;

class RoutesTypesFixtures extends AbstractFixture implements OrderedFixtureInterface {

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

        $repo = $this->manager->getRepository('EsterenMapsBundle:RoutesTypes');

        $this->fixtureObject($repo, 1, 'Chemin', '', 'rgba(165,110,52,1)', '2014-04-27 15:28:15', '2014-04-27 15:28:15', null);
        $this->fixtureObject($repo, 2, 'Route', '', 'rgba(199,191,183,1)', '2014-04-27 15:28:31', '2014-04-27 15:28:31', null);
        $this->fixtureObject($repo, 3, 'Sentier de loup', '', 'rgba(194,176,76,1)', '2014-05-10 16:49:38', '2014-05-10 16:49:38', null);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $color, $created, $updated, $deleted = null)
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
            $obj = new RoutesTypes();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setColor($color)
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
            $this->addReference('esterenmaps-routestypes-'.$id, $obj);
        }
    }
}
<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\TransportTypes;

class TransportTypesFixtures extends AbstractFixture implements OrderedFixtureInterface {

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

        $repo = $this->manager->getRepository('EsterenMapsBundle:TransportsTypes');

        $this->fixtureObject($repo, 1, 'À pied', 'foot', '', 4.5000);
        $this->fixtureObject($repo, 2, 'Chariot', 'chariot', '', 8.0000);
        $this->fixtureObject($repo, 3, 'Cheval', 'cheval', '', 12.0000);
        $this->fixtureObject($repo, 4, 'Caernide', 'caernide', '', 12.0000);


        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $slug, $description, $speed)
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
            $obj = new TransportTypes();
            $obj->setId($id)
                ->setName($name)
                ->setSlug($slug)
                ->setDescription($description)
                ->setSpeed($speed)
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
            $this->addReference('esterenmaps-transports-'.$id, $obj);
        }
    }
}
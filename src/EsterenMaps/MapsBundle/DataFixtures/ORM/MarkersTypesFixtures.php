<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\MarkersTypes;

class MarkersTypesFixtures extends AbstractFixture implements OrderedFixtureInterface
{

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
        return 1;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:MarkersTypes');

        $icon5  = $this->getReference('application-media-5');
        $icon6  = $this->getReference('application-media-6');
        $icon7  = $this->getReference('application-media-7');
        $icon8  = $this->getReference('application-media-8');
        $icon10 = $this->getReference('application-media-10');
        $icon9  = $this->getReference('application-media-9');
        $icon11 = $this->getReference('application-media-11');

        $this->fixtureObject($repo, 1, 'Cité', '', $icon5);
        $this->fixtureObject($repo, 2, 'Port (village côtier, ...)', '', $icon6);
        $this->fixtureObject($repo, 3, 'Carrefour', '', $icon7);
        $this->fixtureObject($repo, 4, 'Sanctuaire', '', $icon8);
        $this->fixtureObject($repo, 5, 'Site d\'intérêt', '', $icon10);
        $this->fixtureObject($repo, 6, 'Fortifications (châteaux, angardes, rosace)', '', $icon9);
        $this->fixtureObject($repo, 7, 'Souterrain (mine, cité troglodyte, réseau de cavernes)', '', $icon11);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $icon)
    {
        $obj       = null;
        $newObject = false;
        $addRef    = false;
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
                ->setIcon($icon)
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
<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\Maps;

class MapsFixtures extends AbstractFixture implements OrderedFixtureInterface {

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
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:Maps');

        $this->fixtureObject($repo, 1, 'Tri-Kazel', 'tri-kazel', 'uploads/maps/esteren_nouvelle_cartepg_91220092.jpeg', 'Carte de Tri-Kazel officielle, réalisée par Chris', 5, 2, 50, 0, '2014-04-09 08:57:25', '2014-04-09 08:57:25');

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $nameSlug, $image, $description, $maxZoom, $startZoom, $startX, $startY, $created, $updated = null)
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
            $obj = new Maps();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setNameSlug($nameSlug)
                ->setImage($image)
                ->setMaxZoom($maxZoom)
                ->setStartZoom($startZoom)
                ->setStartX($startX)
                ->setStartY($startY)
                ->setCreated($created ? new \Datetime($created) : new \Datetime())
                ->setUpdated($updated ? new \Datetime($updated) : null)
                ->setDeleted(null)
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
            $this->addReference('esterenmaps-maps-'.$id, $obj);
        }
    }
}
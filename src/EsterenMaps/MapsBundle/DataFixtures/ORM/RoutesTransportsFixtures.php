<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\RoutesTransports;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use EsterenMaps\MapsBundle\Entity\TransportTypes;

class RoutesTransportsFixtures extends AbstractFixture implements OrderedFixtureInterface
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
        return 5;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:RoutesTransports');

        /** @var RoutesTypes $routeType1 */
        /** @var RoutesTypes $routeType2 */
        /** @var RoutesTypes $routeType3 */
        $routeType1 = $this->getReference('esterenmaps-routestypes-1');
        $routeType2 = $this->getReference('esterenmaps-routestypes-2');
        $routeType3 = $this->getReference('esterenmaps-routestypes-3');

        /** @var TransportTypes $transportType1 */
        /** @var TransportTypes $transportType2 */
        /** @var TransportTypes $transportType3 */
        /** @var TransportTypes $transportType4 */
        $transportType1 = $this->getReference('esterenmaps-transports-1');
        $transportType2 = $this->getReference('esterenmaps-transports-2');
        $transportType3 = $this->getReference('esterenmaps-transports-3');
        $transportType4 = $this->getReference('esterenmaps-transports-4');

        $this->fixtureObject($repo, 1,  $routeType3, $transportType4, 100);
        $this->fixtureObject($repo, 2,  $routeType3, $transportType3, 100);
        $this->fixtureObject($repo, 3,  $routeType3, $transportType2, 100);
        $this->fixtureObject($repo, 4,  $routeType3, $transportType1, 100);
        $this->fixtureObject($repo, 5,  $routeType2, $transportType4, 100);
        $this->fixtureObject($repo, 6,  $routeType2, $transportType3, 100);
        $this->fixtureObject($repo, 7,  $routeType2, $transportType2, 100);
        $this->fixtureObject($repo, 8,  $routeType2, $transportType1, 100);
        $this->fixtureObject($repo, 9,  $routeType1, $transportType4, 100);
        $this->fixtureObject($repo, 10, $routeType1, $transportType3, 100);
        $this->fixtureObject($repo, 11, $routeType1, $transportType2, 100);
        $this->fixtureObject($repo, 12, $routeType1, $transportType1, 100);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, RoutesTypes $routeType, TransportTypes $transportType, $ratio, $positive = false)
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
            $obj = new RoutesTransports();
            $obj->setId($id)
                ->setRouteType($routeType)
                ->setTransportType($transportType)
                ->setPercentage($ratio)
                ->setPositiveRatio($positive)
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
            $this->addReference('esterenmaps-routestransports-'.$id, $obj);
        }
    }

}
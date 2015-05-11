<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use Orbitale\Component\DoctrineTools\AbstractFixture;

class RoutesTransportsFixtures extends AbstractFixture
{

    /**
     * Get the order of this fixture
     * @return integer
     */
    function getOrder()
    {
        return 5;
    }

    /**
     * Returns the class of the entity you're managing
     *
     * @return string
     */
    protected function getEntityClass()
    {
        return 'EsterenMaps\MapsBundle\Entity\RoutesTransports';
    }

    /**
     * Returns a list of objects to
     *
     * @return ArrayCollection|object[]
     */
    protected function getObjects()
    {
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

        return array(
            array('id' => 1, 'routeType' =>  $routeType3, 'transportType' => $transportType4, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 2, 'routeType' =>  $routeType3, 'transportType' => $transportType3, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 3, 'routeType' =>  $routeType3, 'transportType' => $transportType2, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 4, 'routeType' =>  $routeType3, 'transportType' => $transportType1, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 5, 'routeType' =>  $routeType2, 'transportType' => $transportType4, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 6, 'routeType' =>  $routeType2, 'transportType' => $transportType3, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 7, 'routeType' =>  $routeType2, 'transportType' => $transportType2, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 8, 'routeType' =>  $routeType2, 'transportType' => $transportType1, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 9, 'routeType' =>  $routeType1, 'transportType' => $transportType4, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 10, 'routeType' => $routeType1, 'transportType' => $transportType3, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 11, 'routeType' => $routeType1, 'transportType' => $transportType2, 'percentage' => 100, 'positiveRatio' => true),
            array('id' => 12, 'routeType' => $routeType1, 'transportType' => $transportType1, 'percentage' => 100, 'positiveRatio' => true),
        );
    }
}

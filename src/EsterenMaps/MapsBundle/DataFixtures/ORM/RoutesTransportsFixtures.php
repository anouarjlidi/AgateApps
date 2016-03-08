<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Orbitale\Component\DoctrineTools\AbstractFixture;

class RoutesTransportsFixtures extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return 'EsterenMaps\MapsBundle\Entity\RoutesTransports';
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjects()
    {
        $routeType1 = $this->getReference('esterenmaps-routestypes-1');
        $routeType2 = $this->getReference('esterenmaps-routestypes-2');
        $routeType3 = $this->getReference('esterenmaps-routestypes-3');
        $routeType4 = $this->getReference('esterenmaps-routestypes-4');
        $routeType5 = $this->getReference('esterenmaps-routestypes-5');

        $transportType1 = $this->getReference('esterenmaps-transports-1');
        $transportType2 = $this->getReference('esterenmaps-transports-2');
        $transportType3 = $this->getReference('esterenmaps-transports-3');
        $transportType4 = $this->getReference('esterenmaps-transports-4');
        $transportType5 = $this->getReference('esterenmaps-transports-5');
        $transportType6 = $this->getReference('esterenmaps-transports-6');

        return [
            [
                'id'             => 1,
                'routeType'      => $routeType3,
                'transportType'  => $transportType4,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 2,
                'routeType'      => $routeType3,
                'transportType'  => $transportType3,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 3,
                'routeType'      => $routeType3,
                'transportType'  => $transportType2,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 4,
                'routeType'      => $routeType3,
                'transportType'  => $transportType1,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:25'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 5,
                'routeType'      => $routeType2,
                'transportType'  => $transportType4,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 6,
                'routeType'      => $routeType2,
                'transportType'  => $transportType3,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 7,
                'routeType'      => $routeType2,
                'transportType'  => $transportType2,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 8,
                'routeType'      => $routeType2,
                'transportType'  => $transportType1,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:25'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 9,
                'routeType'      => $routeType1,
                'transportType'  => $transportType4,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 10,
                'routeType'      => $routeType1,
                'transportType'  => $transportType3,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 11,
                'routeType'      => $routeType1,
                'transportType'  => $transportType2,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 12,
                'routeType'      => $routeType1,
                'transportType'  => $transportType1,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:06'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:25'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 13,
                'routeType'      => $routeType5,
                'transportType'  => $transportType1,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 12:17:49'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:25'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 14,
                'routeType'      => $routeType5,
                'transportType'  => $transportType2,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:30:21'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:30:21'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 15,
                'routeType'      => $routeType5,
                'transportType'  => $transportType3,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:30:31'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:30:31'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 16,
                'routeType'      => $routeType5,
                'transportType'  => $transportType4,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:30:38'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:30:38'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 17,
                'routeType'      => $routeType5,
                'transportType'  => $transportType5,
                'percentage'     => 100,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:30:46'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:15'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 18,
                'routeType'      => $routeType5,
                'transportType'  => $transportType6,
                'percentage'     => 50,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:30:52'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:09'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 19,
                'routeType'      => $routeType1,
                'transportType'  => $transportType5,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:31:14'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:15'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 20,
                'routeType'      => $routeType1,
                'transportType'  => $transportType6,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:31:20'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:09'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 21,
                'routeType'      => $routeType2,
                'transportType'  => $transportType5,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:31:34'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:15'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 22,
                'routeType'      => $routeType2,
                'transportType'  => $transportType6,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:31:41'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:09'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 23,
                'routeType'      => $routeType3,
                'transportType'  => $transportType5,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:31:47'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:15'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 24,
                'routeType'      => $routeType3,
                'transportType'  => $transportType6,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:31:59'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:09'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 25,
                'routeType'      => $routeType4,
                'transportType'  => $transportType1,
                'percentage'     => 100,
                'positive_ratio' => 1,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:32:41'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:25'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 26,
                'routeType'      => $routeType4,
                'transportType'  => $transportType2,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:32:46'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:32:46'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 27,
                'routeType'      => $routeType4,
                'transportType'  => $transportType3,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:32:51'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:32:51'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 28,
                'routeType'      => $routeType4,
                'transportType'  => $transportType4,
                'percentage'     => 0,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:32:57'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:32:57'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 29,
                'routeType'      => $routeType4,
                'transportType'  => $transportType5,
                'percentage'     => 50,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:33:02'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:15'),
                'deletedAt'      => null,
            ],
            [
                'id'             => 30,
                'routeType'      => $routeType4,
                'transportType'  => $transportType6,
                'percentage'     => 100,
                'positive_ratio' => 0,
                'createdAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-08 13:33:09'),
                'updatedAt'      => \DateTime::createFromFormat('Y-m-d H:i:s', '2016-02-20 17:22:09'),
                'deletedAt'      => null,
            ],
        ];
    }
}

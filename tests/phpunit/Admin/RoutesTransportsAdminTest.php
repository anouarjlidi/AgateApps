<?php

namespace Tests\Admin;

use EsterenMaps\MapsBundle\Entity\RoutesTransports;

class RoutesTransportsAdminTest extends AbstractEasyAdminTest
{

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return 'RoutesTransports';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return RoutesTransports::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListingFields()
    {
        return array(
            'routeType',
            'transportType',
            'percentage',
        );
    }

}

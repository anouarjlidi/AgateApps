<?php

namespace Tests\Admin;

use EsterenMaps\MapsBundle\Entity\ZonesTypes;

class ZonesTypesAdminTest extends AbstractEasyAdminTest
{

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return 'ZonesTypes';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return ZonesTypes::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListingFields()
    {
        return array(
            'id',
            'name',
            'color',
            'parent',
            'zones',
        );
    }

}
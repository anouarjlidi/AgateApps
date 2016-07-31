<?php

namespace AdminBundle\Tests;

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

    /**
     * {@inheritdoc}
     */
    public function provideNewFormData()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function provideEditFormData()
    {
        return false;
    }
}

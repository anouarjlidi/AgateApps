<?php

namespace AdminBundle\Tests;

use EsterenMaps\MapsBundle\Entity\TransportTypes;

class TransportTypesAdminTest extends AbstractEasyAdminTest
{

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return 'TransportTypes';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return TransportTypes::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListingFields()
    {
        return array(
            'id',
            'name',
            'slug',
            'speed',
            'description',
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

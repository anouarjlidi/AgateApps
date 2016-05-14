<?php

namespace Tests\Admin;

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
        // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function provideEditFormData()
    {
        // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function provideIdToDelete()
    {
        return false;
    }

}

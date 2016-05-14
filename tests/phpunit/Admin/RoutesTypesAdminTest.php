<?php

namespace Tests\Admin;

use EsterenMaps\MapsBundle\Entity\RoutesTypes;

class RoutesTypesAdminTest extends AbstractEasyAdminTest
{

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return 'RoutesTypes';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return RoutesTypes::class;
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
            'routes',
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

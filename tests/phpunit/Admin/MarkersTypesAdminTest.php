<?php

namespace Tests\Admin;

use EsterenMaps\MapsBundle\Entity\MarkersTypes;

class MarkersTypesAdminTest extends AbstractEasyAdminTest
{

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return 'MarkersTypes';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return MarkersTypes::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListingFields()
    {
        return array(
            'id',
            'name',
            'webIcon',
            'markers',
        );
    }

}

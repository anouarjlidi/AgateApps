<?php

namespace AdminBundle\Tests;

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
        // Marker1: Cité
        return 1;
    }

}

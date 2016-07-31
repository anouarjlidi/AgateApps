<?php

namespace AdminBundle\Tests;

use EsterenMaps\MapsBundle\Entity\Maps;

class MapsAdminTest extends AbstractEasyAdminTest
{

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return 'Maps';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return Maps::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListingFields()
    {
        return array(
            'id',
            'name',
            'nameSlug',
            'maxZoom',
            'startZoom',
            'startX',
            'startY',
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

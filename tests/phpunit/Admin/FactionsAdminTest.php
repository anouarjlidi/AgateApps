<?php

namespace Tests\Admin;

use EsterenMaps\MapsBundle\Entity\Factions;

class FactionsAdminTest extends AbstractEasyAdminTest
{

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return 'Factions';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return Factions::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListingFields()
    {
        return array(
            'id',
            'name',
            'description',
            'book',
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

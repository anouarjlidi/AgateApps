<?php

namespace Tests\Admin;

use Orbitale\Bundle\CmsBundle\Entity\Page;

class PagesAdminTest extends AbstractEasyAdminTest
{

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return 'Pages';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return Page::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideListingFields()
    {
        return array(
            'id',
            'parent',
            'title',
            'slug',
            'tree',
            'host',
            'locale',
            'homepage',
            'enabled',
        );
    }

}

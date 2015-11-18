<?php


namespace Tests\Admin;

use Orbitale\Bundle\CmsBundle\Entity\Page;

class PageAdminTest extends AbstractEasyAdminTest
{

    //TODO: Test page creation

    //TODO: Test page edition

    //TODO: Test page deletion

    public function getEntityName()
    {
        return 'Page';
    }

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

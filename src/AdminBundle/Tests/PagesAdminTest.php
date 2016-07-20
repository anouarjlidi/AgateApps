<?php

namespace AdminBundle\Tests;

use Doctrine\ORM\EntityManager;
use Esteren\PortalBundle\Entity\Page;

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

    /**
     * {@inheritdoc}
     */
    public function provideNewFormData()
    {
        return [
            'title'           => 'Testing new page',
            'content'         => 'This is a page to test the "new" form.',
            'metaDescription' => '',
            'metaTitle'       => '',
            'metaKeywords'    => '',
            'css'             => '',
            'js'              => '',
            'category'        => '',
            'parent'          => '',
            'host'            => '',
            'homepage'        => false,
            'enabled'         => true,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function provideEditFormData()
    {
        return [
            'id'              => 1,
            'title'           => 'Testing new page',
            'content'         => 'This is a page to test the "new" form.',
            'metaDescription' => '',
            'metaTitle'       => '',
            'metaKeywords'    => '',
            'css'             => '',
            'js'              => '',
            'category'        => '',
            'parent'          => '',
            'host'            => '',
            'homepage'        => false,
            'enabled'         => true,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function provideIdToDelete()
    {
        static::bootKernel();

        /** @var EntityManager $em */
        $em = static::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $page = $em
            ->getRepository('EsterenPortalBundle:Page')
            ->findOneBy([])
        ;

        static::$kernel->shutdown();

        return $page->getId();
    }
}

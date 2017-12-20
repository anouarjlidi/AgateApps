<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Admin;

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
        return [
            'id',
            'parent',
            'title',
            'slug',
            'tree',
            'host',
            'locale',
            'homepage',
            'enabled',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function provideNewFormData()
    {
        return [
            'title'           => 'Testing new page '.uniqid('Page', true),
            'content'         => 'This is a page to test the "new" form.',
            'metaDescription' => null,
            'metaTitle'       => null,
            'metaKeywords'    => null,
            'css'             => null,
            'js'              => null,
            'category'        => null,
            'parent'          => null,
            'host'            => null,
            'homepage'        => false,
            'enabled'         => true,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function provideEditFormData()
    {
        static::bootKernel();

        $pageId = static::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository('EsterenPortalBundle:Page')
            ->findOneBy([])
            ->getId()
        ;

        static::$kernel->shutdown();

        return [
            'id'              => $pageId,
            'title'           => 'Testing new page',
            'content'         => 'This is a page to test the "new" form.',
            'metaDescription' => null,
            'metaTitle'       => null,
            'metaKeywords'    => null,
            'css'             => null,
            'js'              => null,
            'category'        => null,
            'parent'          => null,
            'host'            => null,
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

        $pageId = static::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository('EsterenPortalBundle:Page')
            ->findOneBy([])
            ->getId()
        ;

        static::$kernel->shutdown();

        return $pageId;
    }
}

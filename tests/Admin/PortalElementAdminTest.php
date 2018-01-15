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

use Agate\Entity\PortalElement;

class PortalElementAdminTest extends AbstractEasyAdminTest
{
    private $formEntityFieldName;
    private $file;

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return 'PortalElement';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return PortalElement::class;
    }

    protected function setUp()
    {
        parent::setUp();
        if (!$this->formEntityFieldName) {
            $this->formEntityFieldName = strtolower($this->getEntityName());
        }
        $this->file = tempnam(sys_get_temp_dir(), 'portal_element_admin_test');
    }

    protected function tearDown()
    {
        parent::tearDown();
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function provideListingFields()
    {
        return [
            'id',
            'portal',
            'locale',
            'imageUrl',
            'title',
            'subtitle',
            'buttonText',
        ];
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

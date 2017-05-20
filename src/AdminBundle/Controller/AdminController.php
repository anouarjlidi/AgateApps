<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_MANAGER')")
 */
class AdminController extends BaseAdminController
{
    /**
     * @Route("/", name="easyadmin")
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }

    protected function joinBooks(QueryBuilder $qb): QueryBuilder
    {
        $qb->leftJoin('entity.book', 'book')->addSelect('book');

        return $qb;
    }
}

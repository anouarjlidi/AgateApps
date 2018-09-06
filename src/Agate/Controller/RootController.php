<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\Controller;

use Main\DependencyInjection\PublicService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class RootController extends AbstractController implements PublicService
{
    public function __invoke(string $_locale = null): Response
    {
        if (!$_locale) {
            $_locale = 'fr';
        }

        return new RedirectResponse("/$_locale/", 301);
    }
}

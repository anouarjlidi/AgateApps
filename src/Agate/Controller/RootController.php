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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RootController extends AbstractController implements PublicService
{
    private $locales;

    public function __construct(array $locales)
    {
        $this->locales = $locales;
    }

    public function __invoke(Request $request, string $_locale = null): Response
    {
        if (!$_locale) {
            $_locale = $request->getPreferredLanguage(\array_values($this->locales));
        }

        return new RedirectResponse("/$_locale/", 301);
    }
}

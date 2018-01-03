<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CorahnRinHomeController extends AbstractController
{
    private $debug;
    private $versionDate;

    public function __construct(bool $debug, string $versionDate)
    {
        $this->debug = $debug;
        $this->versionDate = $versionDate;
    }

    /**
     * @Route("/", name="corahn_rin_home")
     */
    public function indexAction(Request $request): Response
    {
        $response = new Response();
        if (!$this->debug) {
            $response->setCache([
                'last_modified' => new \DateTime($this->versionDate),
                'max_age' => 600,
                's_maxage' => 600,
                'public' => true,
            ]);
        }

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $this->render('corahn_rin/home/index.html.twig');
    }
}

<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Twig;

use EsterenMaps\MapsBundle\Repository\MapsRepository;

class MapsExtension extends \Twig_Extension
{
    /**
     * @var MapsRepository
     */
    private $repository;

    public function __construct(MapsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_menu_maps', [$this, 'getMaps']),
        ];
    }

    public function getMaps()
    {
        // Add all maps to the Maps dropdown menu entry.
        return $this->repository->findForMenu();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'esterenmaps';
    }
}

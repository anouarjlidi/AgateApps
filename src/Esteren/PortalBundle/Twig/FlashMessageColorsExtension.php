<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esteren\PortalBundle\Twig;

class FlashMessageColorsExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_flash_class', [$this, 'getFlashClass']),
        ];
    }

    public function getFlashClass($initialClass)
    {
        switch ($initialClass) {
            case 'alert':
            case 'error':
            case 'danger':
                return 'red lighten-3';
            case 'warning':
                return 'orange lighten-3';
            case 'info':
                return 'teal lighten-3';
            case 'success':
                return 'green lighten-3';
            default:
                return '';
        }
    }
}

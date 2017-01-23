<?php

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
                return 'red lighten-4';
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

<?php

namespace CorahnRin\Twig;

use CorahnRin\Data\DomainsData;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DomainsExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('get_domain_as_object', [DomainsData::class, 'getAsObject']),
        ];
    }
}

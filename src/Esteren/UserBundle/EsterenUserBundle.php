<?php

namespace Esteren\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EsterenUserBundle extends Bundle {

    public function getParent()
    {
        return 'FOSUserBundle';
    }

}

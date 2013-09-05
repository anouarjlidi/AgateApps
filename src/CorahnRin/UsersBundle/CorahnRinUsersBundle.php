<?php

namespace CorahnRin\UsersBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CorahnRinUsersBundle extends Bundle {
    public function getParent() {
        return 'FOSUserBundle';
    }
}

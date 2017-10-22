<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Data;

/**
 * Data objects are used when some logic cannot be put in the Database.
 * It saves some db queries, forces to use static behaviors, constants, etc.
 * It's much safer than database, because it cannot be corrupted.
 *
 * Please use this whenever you use data that have no relation with any other entity.
 */
interface DataInterface
{
    /**
     * @return mixed
     */
    public static function getData();
}

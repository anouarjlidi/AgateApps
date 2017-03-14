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

final class ItemAvailability implements DataInterface
{
    const COMMON = 'CO';
    const FREQUENT = 'FR';
    const RARE = 'RA';
    const EXCEPTIONAL = 'EX';

    private function __construct()
    {
    }

    public static function getData()
    {
        return [
            static::COMMON      => 'availability.common',
            static::FREQUENT    => 'availability.frequent',
            static::RARE        => 'availability.rare',
            static::EXCEPTIONAL => 'availability.exceptional',
        ];
    }
}

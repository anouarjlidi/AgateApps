<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Data;

final class ItemAvailability implements DataInterface
{
    public const COMMON      = 'CO';
    public const FREQUENT    = 'FR';
    public const RARE        = 'RA';
    public const EXCEPTIONAL = 'EX';

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

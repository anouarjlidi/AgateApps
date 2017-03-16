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

final class Orientation implements DataInterface
{
    const INSTINCTIVE = 'character.orientation.instinctive';

    const RATIONAL = 'character.orientation.rational';

    /**
     * Don't allow construction of this class.
     */
    private function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getData()
    {
        return [
            static::INSTINCTIVE => [
                'name'        => 'Instinctive',
                'description' => static::INSTINCTIVE,
            ],
            static::RATIONAL => [
                'name'        => 'Rationnelle',
                'description' => static::RATIONAL,
            ],
        ];
    }
}

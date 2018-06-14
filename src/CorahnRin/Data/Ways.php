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

final class Ways
{
    public const COMBATIVENESS = 'combativeness';
    public const CREATIVITY = 'creativity';
    public const EMPATHY = 'empathy';
    public const REASON = 'reason';
    public const CONVICTION = 'conviction';

    public const ALL = [
        self::COMBATIVENESS => self::COMBATIVENESS.'.description',
        self::CREATIVITY => self::CREATIVITY.'.description',
        self::EMPATHY => self::EMPATHY.'.description',
        self::REASON => self::REASON.'.description',
        self::CONVICTION => self::CONVICTION.'.description',
    ];

    public static function validateWay(string $way): void
    {
        if (!isset(static::ALL[$way])) {
            throw new \InvalidArgumentException(sprintf(
                'Provided way "%s" is not a valid way. Possible values: %s',
                $way, implode(', ', array_keys(static::ALL))
            ));
        }
    }
}

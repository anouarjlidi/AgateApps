<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Exception;

/**
 * Class CharactersException
 * Project corahn_rin.
 *
 * @author Pierstoval
 *
 * @version 1.0 20/02/2014
 */
class CharactersException extends \Exception
{
    public function __construct($message = '', $code = 0, $previous = null)
    {
        $message = 'Character error: '.$message;
        parent::__construct($message, $code, $previous);
    }
}

<?php

namespace CorahnRin\CorahnRinBundle\Exception;

/**
 * Class CharactersException
 * Project corahn_rin
 *
 * @author Pierstoval
 * @version 1.0 20/02/2014
 */
class CharactersException extends \Exception {

    function __construct($message = '', $code = 0, $previous = null) {
        $message = 'Character error: '.$message;
        parent::__construct($message, $code, $previous);
    }

}

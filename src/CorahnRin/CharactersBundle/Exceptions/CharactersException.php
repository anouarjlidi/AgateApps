<?php

namespace CorahnRin\CharactersBundle\Exceptions;

/**
 * Class CharactersException
 * Project corahn_rin
 *
 * @author Pierstoval
 * @version 1.0 20/02/2014
 */
class CharactersException extends \Exception {

    function __construct($message, $code, $previous) {
        $message = 'Erreur de type "Characters" : '.$message;
        parent::__construct($message, $code, $previous);
    }

}

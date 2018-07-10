<?php

declare(strict_types=1);

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace User\Security\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Throwable;

class EmailNotConfirmedException extends AccountStatusException
{
    private const EXCEPTION_MESSAGE = 'Email is not confirmed.';

    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: static::EXCEPTION_MESSAGE, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return static::EXCEPTION_MESSAGE;
    }
}

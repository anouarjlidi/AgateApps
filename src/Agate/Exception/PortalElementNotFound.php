<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PortalElementNotFound extends NotFoundHttpException
{
    public function __construct(string $portal, string $locale)
    {
        parent::__construct(\sprintf('Portal element "%s" with locale "%s" not found.', $portal, $locale));
    }
}

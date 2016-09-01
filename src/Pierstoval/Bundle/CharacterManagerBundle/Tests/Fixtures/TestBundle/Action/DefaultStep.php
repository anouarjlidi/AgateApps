<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pierstoval\Bundle\CharacterManagerBundle\Tests\Fixtures\TestBundle\Action;

use Pierstoval\Bundle\CharacterManagerBundle\Action\StepAction;
use Symfony\Component\HttpFoundation\Response;

class DefaultStep extends StepAction
{

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        return new Response('Working');
    }
}

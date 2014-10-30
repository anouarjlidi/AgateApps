<?php

namespace Pierstoval\Bundle\CorsBundle\Options;

use Symfony\Component\HttpFoundation\Request;

interface ResolverInterface
{
    /**
     * Returns CORS options for $path
     *
     * @param Request $request
     *
     * @internal param string $path
     *
     * @return mixed
     */
    public function getOptions(Request $request);
}

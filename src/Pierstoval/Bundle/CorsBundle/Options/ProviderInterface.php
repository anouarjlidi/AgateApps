<?php

namespace Pierstoval\Bundle\CorsBundle\Options;

use Symfony\Component\HttpFoundation\Request;

/**
 * CORS configuration provider interface.
 *
 * Can override CORS options for a particular path.
 */
interface ProviderInterface
{
    /**
     * Returns CORS options for $request.
     *
     * Any valid CORS option will overwrite those of the previous ones.
     * The method must at least return an empty array.
     *
     * All keys of the bundle's semantical configuration are valid:
     * - bool allow_credentials
     * - bool allow_origin
     * - bool allow_headers
     * - array allow_methods
     * - array expose_headers
     * - int max_age
     *
     * @param Request $request
     *
     * @return array CORS options
     */
    public function getOptions(Request $request);
}

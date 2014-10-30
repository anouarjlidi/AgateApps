<?php

namespace Pierstoval\Bundle\CorsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Pierstoval\Bundle\CorsBundle\DependencyInjection\Compiler\CorsConfigurationProviderPass;

class PierstovalCorsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new CorsConfigurationProviderPass());
    }
}

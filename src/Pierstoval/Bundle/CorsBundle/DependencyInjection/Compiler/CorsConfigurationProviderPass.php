<?php

namespace Pierstoval\Bundle\CorsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiler pass for the pierstoval_cors.configuration.provider tag.
 */
class CorsConfigurationProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('pierstoval_cors.options_resolver')) {
            return;
        }

        $resolverDefinition = $container->getDefinition('pierstoval_cors.options_resolver');

        $optionsProvidersByPriority = array();
        foreach ($container->findTaggedServiceIds('pierstoval_cors.options_provider') as $taggedServiceId => $tagAttributes) {
            foreach ($tagAttributes as $attribute) {
                $priority = isset($attribute['priority']) ? $attribute['priority'] : 0;
                $optionsProvidersByPriority[$priority][] = new Reference($taggedServiceId);
            }
        }

        if (count($optionsProvidersByPriority) > 0) {
            $resolverDefinition->setArguments(
                array($this->sortProviders($optionsProvidersByPriority))
            );
        }
    }

    /**
     * Transforms a two-dimensions array of providers, indexed by priority, into a flat array of Reference objects
     * @param  array       $providersByPriority
     * @return Reference[]
     */
    protected function sortProviders(array $providersByPriority)
    {
        ksort($providersByPriority);

        return call_user_func_array('array_merge', $providersByPriority);
    }
}

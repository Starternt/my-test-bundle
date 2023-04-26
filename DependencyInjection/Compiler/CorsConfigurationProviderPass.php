<?php

namespace Starternh\MyTestBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiler pass for the my_test.configuration.provider tag.
 */
class CorsConfigurationProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('my_test.options_resolver')) {
            return;
        }

        $resolverDefinition = $container->getDefinition('my_test.options_resolver');

        $optionsProvidersByPriority = [];
        foreach ($container->findTaggedServiceIds('my_test.options_provider') as $taggedServiceId => $tagAttributes) {
            foreach ($tagAttributes as $attribute) {
                $priority = isset($attribute['priority']) ? $attribute['priority'] : 0;
                $optionsProvidersByPriority[$priority][] = new Reference($taggedServiceId);
            }
        }

        if (count($optionsProvidersByPriority) > 0) {
            $resolverDefinition->setArguments(
                [$this->sortProviders($optionsProvidersByPriority)]
            );
        }
    }

    /**
     * Transforms a two-dimensions array of providers, indexed by priority, into a flat array of Reference objects
     * @param  array       $providersByPriority
     * @return Reference[]
     */
    protected function sortProviders(array $providersByPriority): array
    {
        ksort($providersByPriority);

        return call_user_func_array('array_merge', $providersByPriority);
    }
}

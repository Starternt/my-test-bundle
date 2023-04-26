<?php

namespace Starternh\MyTestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('my_test');
        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('credentials')
                    ->children()
                        ->scalarNode('base_url')->end()
                        ->scalarNode('token')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}


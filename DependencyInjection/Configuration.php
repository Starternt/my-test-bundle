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
        $treeBuilder = new TreeBuilder('starternh_my_test');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('my_test')
                    ->children()
                        ->integerNode('base_url')->end()
                        ->scalarNode('token')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}


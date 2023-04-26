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
            ->booleanNode('isDisplay')->defaultTrue()->end()
            ->booleanNode('someBoolean')->defaultTrue()->end()
            ->end()
        ;
        return $treeBuilder;
    }
}


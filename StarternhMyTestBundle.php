<?php

namespace Starternh\MyTestBundle;

use Starternh\MyTestBundle\DependencyInjection\StarternhMyTestExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class StarternhMyTestBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new DependencyInjection\Compiler\CorsConfigurationProviderPass());
    }

    public function getContainerExtension(): StarternhMyTestExtension
    {
        return new StarternhMyTestExtension();
    }
}

<?php

namespace Starternh\MyTestBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class StarternhMyTestBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new DependencyInjection\Compiler\CorsConfigurationProviderPass());
    }
}

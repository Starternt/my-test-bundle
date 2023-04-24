<?php

namespace Starternh\MyTestBundle;

use Starternh\MyTestBundle\DependencyInjection\StarternhMyTestExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class StarternhMyTestBundle extends Bundle
{
    public function getContainerExtension(): StarternhMyTestExtension
    {
        return new StarternhMyTestExtension();
    }
}

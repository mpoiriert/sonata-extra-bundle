<?php

namespace Draw\Bundle\SonataExtraBundle;

use Draw\Bundle\SonataExtraBundle\DependencyInjection\Compiler\AutoConfigureSubClassesCompilerClass;
use Draw\Bundle\SonataExtraBundle\DependencyInjection\Compiler\DecoratesCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DrawSonataExtraBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(
            new AutoConfigureSubClassesCompilerClass(),
            PassConfig::TYPE_BEFORE_OPTIMIZATION,
            -1
        );

        $container->addCompilerPass(new DecoratesCompilerPass());
    }
}

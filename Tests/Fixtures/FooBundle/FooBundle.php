<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle;

use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\Pass\LoggerPass;

class FooBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new LoggerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, -64);
    }
}

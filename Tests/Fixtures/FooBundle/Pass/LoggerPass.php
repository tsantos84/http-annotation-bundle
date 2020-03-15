<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\Pass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class LoggerPass.
 */
class LoggerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('logger')) {
            return;
        }

        $container->removeDefinition('logger');
    }
}

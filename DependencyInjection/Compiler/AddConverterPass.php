<?php

namespace TSantos\HttpAnnotationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AddConverterPass.
 */
class AddConverterPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('tsantos_argument_resolver.composite_resolver')) {
            return;
        }

        $arguments = [];

        foreach ($this->findAndSortTaggedServices('tsantos_argument_resolver.resolver', $container) as $service) {
            $arguments[] = new Reference($service);
        }

        $definition = $container->getDefinition('tsantos_argument_resolver.composite_resolver');
        $definition->setArgument(0, $arguments);
    }
}

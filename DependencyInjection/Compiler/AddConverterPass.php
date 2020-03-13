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
        if (!$container->hasDefinition('tsantos_request.converter_registry')) {
            return;
        }

        $arguments = [];

        foreach ($this->findAndSortTaggedServices('tsantos_request.converter', $container) as $service) {
            $arguments[] = new Reference($service);
        }

        $definition = $container->getDefinition('tsantos_request.converter_registry');
        $definition->setArgument(0, $arguments);
    }
}

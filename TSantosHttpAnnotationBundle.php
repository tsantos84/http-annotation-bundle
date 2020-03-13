<?php

namespace TSantos\HttpAnnotationBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TSantos\HttpAnnotationBundle\DependencyInjection\Compiler\AddConverterPass;

/**
 * Class RequestBundle.
 */
class TSantosHttpAnnotationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddConverterPass());
    }
}

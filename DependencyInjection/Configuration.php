<?php

namespace TSantos\HttpAnnotationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('tsantos_request_converter');

        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}

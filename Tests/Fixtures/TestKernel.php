<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\FooBundle;
use TSantos\HttpAnnotationBundle\TSantosHttpAnnotationBundle;

class TestKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new TSantosHttpAnnotationBundle(),
            new FooBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__.'/config/config.yaml');
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return __DIR__.'/../../var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return __DIR__.'/../../var/log';
    }
}

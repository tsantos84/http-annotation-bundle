<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use TSantos\HttpAnnotationBundle\HttpAnnotationBundle;
use TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\FooBundle;

class TestKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new HttpAnnotationBundle(),
            new FooBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
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

<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractFunctionalTest extends WebTestCase
{
    protected function tearDown(): void
    {
        $varDirectory = dirname(static::$kernel->getLogDir());

        if (is_dir($varDirectory)) {
            $finder = new Filesystem();
            $finder->remove($varDirectory);
        }

        parent::tearDown();
    }
}

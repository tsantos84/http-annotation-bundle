<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractFunctionalTest extends WebTestCase
{
    public static function tearDownAfterClass(): void
    {
        $varDirectory = dirname(dirname(__DIR__)).'/var';

        if (is_dir($varDirectory)) {
            $finder = new Filesystem();
            $finder->remove($varDirectory);
        }

        parent::tearDownAfterClass();
    }
}

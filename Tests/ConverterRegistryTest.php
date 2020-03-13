<?php

namespace TSantos\HttpAnnotationBundle\Testss;

use PHPUnit\Framework\TestCase;
use TSantos\HttpAnnotationBundle\ConverterRegistry;

/**
 * @internal
 * @coversNothing
 */
class ConverterRegistryTest extends TestCase
{
    public function testAddShouldAvoidIncludingItself()
    {
        $registry = new ConverterRegistry([]);
        $registry->add($registry);

        $this->assertCount(0, $registry);
    }
}

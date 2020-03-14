<?php

namespace TSantos\HttpAnnotationBundle\Testss;

use PHPUnit\Framework\TestCase;
use TSantos\HttpAnnotationBundle\ArgumentResolverRegistry;

/**
 * @internal
 * @coversNothing
 */
class ArgumentResolverRegistryTest extends TestCase
{
    public function testAddShouldAvoidIncludingItself()
    {
        $registry = new ArgumentResolverRegistry([]);
        $registry->add($registry);

        $this->assertCount(0, $registry);
    }
}

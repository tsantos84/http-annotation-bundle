<?php

namespace TSantos\HttpAnnotationBundle\Testss;

use PHPUnit\Framework\TestCase;
use TSantos\HttpAnnotationBundle\ArgumentResolver\CompositeResolver;

/**
 * @internal
 * @coversNothing
 */
class ArgumentResolverRegistryTest extends TestCase
{
    public function testAddShouldAvoidIncludingItself(): void
    {
        $compositeResolver = new CompositeResolver([]);
        $compositeResolver->add($compositeResolver);

        $this->assertCount(0, $compositeResolver);
    }
}

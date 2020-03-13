<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\Model;

/**
 * Class Foo.
 */
class Foo
{
    public string $foo;
    public string $bar;
    public string $baz;

    public function getFoo(): string
    {
        return $this->foo;
    }
}

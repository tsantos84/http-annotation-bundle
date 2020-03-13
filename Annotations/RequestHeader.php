<?php

namespace TSantos\HttpAnnotationBundle\Annotations;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestHeader.
 *
 * @Annotation
 */
class RequestHeader extends Annotation
{
    public ?string $name = null;

    public function initialize(\ReflectionMethod $reflectionMethod, Request $request): void
    {
        parent::initialize($reflectionMethod, $request);

        if (null === $this->name) {
            $this->name = $this->parameter->getName();
        }
    }
}

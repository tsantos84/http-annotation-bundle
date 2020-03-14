<?php

namespace TSantos\HttpAnnotationBundle\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;

interface ArgumentResolverInterface
{
    public function resolve(Annotation $annotation, Request $request): void;

    public function supports(Annotation $annotation, Request $request): bool;
}

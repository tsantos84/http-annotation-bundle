<?php

namespace TSantos\HttpAnnotationBundle\Converter;

use Symfony\Component\HttpFoundation\Request;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;

interface ConverterInterface
{
    public function convert(Annotation $annotation, Request $request): void;

    public function supports(Annotation $annotation, Request $request): bool;
}

<?php

namespace TSantos\HttpAnnotationBundle\Converter\RequestBody;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Annotations\RequestBody;
use TSantos\HttpAnnotationBundle\Converter\ConverterInterface;

class StringConverter implements ConverterInterface
{
    public function convert(Annotation $annotation, Request $request): void
    {
        $content = $request->getContent();

        if (empty($content)) {
            if ($annotation->required) {
                throw new HttpException(Response::HTTP_BAD_REQUEST);
            }

            $request->attributes->set($annotation->value, null);
            return;
        }

        $request->attributes->set($annotation->value, (string) $content);
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        return $annotation instanceof RequestBody
            && $annotation->parameter->hasType()
            && 'string' === $annotation->parameter->getType()->getName();
    }
}

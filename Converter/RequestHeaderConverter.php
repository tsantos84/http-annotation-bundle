<?php

namespace TSantos\HttpAnnotationBundle\Converter;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Annotations\RequestHeader;

class RequestHeaderConverter implements ConverterInterface
{
    public function convert(Annotation $annotation, Request $request): void
    {
        if (HeaderBag::class === $annotation->parameter->getType()->getName()) {
            $request->attributes->set($annotation->value, $request->headers);

            return;
        }

        if ($request->headers->has($annotation->name)) {
            $request->attributes->set($annotation->value, $request->headers->get($annotation->name));

            return;
        }

        if (!$annotation->required) {
            return;
        }

        throw new HttpException(Response::HTTP_BAD_REQUEST, sprintf('Missing required request header "%s"', $annotation->name));
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        return $annotation instanceof RequestHeader;
    }
}

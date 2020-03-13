<?php

namespace TSantos\HttpAnnotationBundle\Converter;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Annotations\RequestCookie;
use TSantos\HttpAnnotationBundle\Traits\ValidatorTrait;

class RequestCookieConverter implements ConverterInterface
{
    use ValidatorTrait;

    public function convert(Annotation $annotation, Request $request): void
    {
        $cookies = $request->cookies;

        if (ParameterBag::class === $annotation->parameter->getType()->getName()) {
            $request->attributes->set($annotation->value, $cookies);

            return;
        }

        if ($cookies->has($annotation->name)) {
            $value = $cookies->get($annotation->name);
            $this->validate($annotation, $value);
            $request->attributes->set($annotation->value, $value);

            return;
        }

        if (!$annotation->required) {
            return;
        }

        throw new HttpException(Response::HTTP_BAD_REQUEST, sprintf('Missing required request cookie "%s"', $annotation->name));
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        return $annotation instanceof RequestCookie;
    }
}

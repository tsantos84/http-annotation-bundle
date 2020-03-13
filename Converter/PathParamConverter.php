<?php

namespace TSantos\HttpAnnotationBundle\Converter;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Annotations\PathParam;
use TSantos\HttpAnnotationBundle\Traits\ValidatorTrait;

class PathParamConverter implements ConverterInterface
{
    use ValidatorTrait;

    public function convert(Annotation $annotation, Request $request): void
    {
        if (ParameterBag::class === $annotation->parameter->getType()->getName()) {
            $request->attributes->set($annotation->value, $request->attributes);

            return;
        }

        $params = $request->attributes->get('_route_params');

        if (isset($params[$annotation->name])) {
            $value = $request->attributes->get($annotation->name);
            $this->validate($annotation, $value);
            $request->attributes->set($annotation->value, $value);

            return;
        }

        if (!$annotation->required) {
            return;
        }

        throw new HttpException(Response::HTTP_BAD_REQUEST, sprintf('Missing required path param "%s"', $annotation->name));
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        return $annotation instanceof PathParam;
    }
}

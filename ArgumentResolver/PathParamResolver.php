<?php

namespace TSantos\HttpAnnotationBundle\ArgumentResolver;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Annotations\PathParam;
use TSantos\HttpAnnotationBundle\Traits\ValidatorTrait;

class PathParamResolver implements ArgumentResolverInterface
{
    use ValidatorTrait;

    /**
     * @param Annotation|PathParam $annotation
     */
    public function resolve(Annotation $annotation, Request $request): void
    {
        if ($annotation->parameter->hasType() && ParameterBag::class === $annotation->parameter->getType()->getName()) {
            $request->attributes->set($annotation->value, $request->attributes);

            return;
        }

        $params = $request->attributes->get('_route_params');

        if (isset($params[$annotation->name])) {
            $value = $request->attributes->get($annotation->name);
            $request->attributes->set($annotation->value, $value);
            $this->validate($annotation, $value);

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

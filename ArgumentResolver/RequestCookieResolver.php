<?php

namespace TSantos\HttpAnnotationBundle\ArgumentResolver;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Annotations\RequestCookie;
use TSantos\HttpAnnotationBundle\Traits\ValidatorTrait;

class RequestCookieResolver implements ArgumentResolverInterface
{
    use ValidatorTrait;

    /**
     * @param Annotation|RequestCookie $annotation
     */
    public function resolve(Annotation $annotation, Request $request): void
    {
        $cookies = $request->cookies;

        if (ParameterBag::class === $annotation->parameter->getType()->getName()) {
            $request->attributes->set($annotation->value, $cookies);

            return;
        }

        if ($cookies->has($annotation->name)) {
            $value = $cookies->get($annotation->name);
            $request->attributes->set($annotation->value, $value);
            $this->validate($annotation, $value);

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

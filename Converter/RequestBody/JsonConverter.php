<?php

namespace TSantos\HttpAnnotationBundle\Converter\RequestBody;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Annotations\RequestBody;
use TSantos\HttpAnnotationBundle\Converter\ConverterInterface;

class JsonConverter implements ConverterInterface
{
    public function convert(Annotation $annotation, Request $request): void
    {
        $content = $request->getContent();

        if ($annotation->required && empty($content)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        $content = json_decode($content, true);

        if (json_last_error() > 0) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        $request->attributes->set($annotation->value, $content);
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        return $annotation instanceof RequestBody
            && 'json' === $request->getContentType()
            && $annotation->parameter->hasType()
            && $annotation->parameter->getType()->isBuiltin();
    }
}

<?php

namespace TSantos\HttpAnnotationBundle\ArgumentResolver\RequestBody;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Annotations\RequestBody;
use TSantos\HttpAnnotationBundle\ArgumentResolver\ArgumentResolverInterface;
use TSantos\HttpAnnotationBundle\Deserialization\DeserializationInterface;

class ComplexTypeResolver implements ArgumentResolverInterface
{
    private DeserializationInterface $deserialization;

    public function __construct(DeserializationInterface $deserialization)
    {
        $this->deserialization = $deserialization;
    }

    public function resolve(Annotation $annotation, Request $request): void
    {
        $content = $request->getContent();

        if ($annotation->required && empty($content)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        $options = $annotation->serializationGroups;

        $result = $this->deserialization->deserialize($content, $annotation->parameter->getType()->getName(), $request->getContentType(), $options);
        $request->attributes->set($annotation->value, $result);
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        return $annotation instanceof RequestBody
            && $annotation->parameter->hasType()
            && !$annotation->parameter->getType()->isBuiltin();
    }
}

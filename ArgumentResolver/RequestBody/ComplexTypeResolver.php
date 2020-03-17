<?php

namespace TSantos\HttpAnnotationBundle\ArgumentResolver\RequestBody;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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

    /**
     * @param Annotation|RequestBody $annotation
     */
    public function resolve(Annotation $annotation, Request $request): void
    {
        $content = (string) $request->getContent();

        if ($annotation->required && empty($content)) {
            throw new BadRequestHttpException('Missing content body');
        }

        if (null === $contentType = $request->getContentType()) {
            throw new BadRequestHttpException('Missing content type');
        }

        $options = $annotation->serializationGroups;

        $result = $this->deserialization->deserialize($content, $annotation->parameter->getType()->getName(), $contentType, $options);
        $request->attributes->set($annotation->value, $result);
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        return $annotation instanceof RequestBody
            && $annotation->parameter->hasType()
            && !$annotation->parameter->getType()->isBuiltin();
    }
}

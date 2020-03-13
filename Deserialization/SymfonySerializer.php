<?php

namespace TSantos\HttpAnnotationBundle\Deserialization;

use Symfony\Component\Serializer\SerializerInterface;

class SymfonySerializer implements DeserializationInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function deserialize(string $content, string $type, string $format, array $options = [])
    {
        return $this->serializer->deserialize($content, $type, $format, $options);
    }
}

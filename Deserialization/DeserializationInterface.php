<?php

namespace TSantos\HttpAnnotationBundle\Deserialization;

interface DeserializationInterface
{
    public function deserialize(string $content, string $type, string $format, array $options = []);
}

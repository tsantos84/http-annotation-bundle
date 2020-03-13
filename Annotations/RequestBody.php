<?php

namespace TSantos\HttpAnnotationBundle\Annotations;

/**
 * @Annotation
 */
class RequestBody extends Annotation
{
    public ?array $serializationGroups = [];
}

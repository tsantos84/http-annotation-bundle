<?php

namespace TSantos\HttpAnnotationBundle\Traits;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Exception\ConstraintViolationException;

trait ValidatorTrait
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    private function validate(Annotation $annotation, $value): void
    {
        if (empty($annotation->constraints)) {
            return;
        }

        $violations = $this->validator->validate($value, $annotation->constraints);

        if ($violations->count()) {
            throw new ConstraintViolationException($violations);
        }
    }
}

<?php

namespace TSantos\HttpAnnotationBundle\Traits;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;

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

        $result = $this->validator->validate($value, $annotation->constraints);

        if ($result->count()) {
            throw new HttpException(400);
        }
    }
}

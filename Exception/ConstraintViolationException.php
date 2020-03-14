<?php

namespace TSantos\HttpAnnotationBundle\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ConstraintViolationException extends HttpException
{
    private ConstraintViolationListInterface $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, 'Your request contains some constraint violations');
        $this->violations = $violations;
    }
}

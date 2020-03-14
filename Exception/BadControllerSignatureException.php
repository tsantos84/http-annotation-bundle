<?php

namespace TSantos\HttpAnnotationBundle\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final class BadControllerSignatureException extends \LogicException
{
    public function __construct(\ReflectionMethod $controller)
    {
        $message = sprintf(
            'The controller "%s::%s" has more than one argument type-hinted with "%s" class',
            $controller->getName(),
            $controller->getName(),
            ConstraintViolationListInterface::class
        );
        parent::__construct($message);
    }
}

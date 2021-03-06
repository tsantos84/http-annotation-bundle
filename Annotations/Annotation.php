<?php

namespace TSantos\HttpAnnotationBundle\Annotations;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use TSantos\HttpAnnotationBundle\Exception\InvalidArgumentException;

abstract class Annotation
{
    public string $value;
    public bool $required;
    public \ReflectionParameter $parameter;
    public array $constraints = [];

    public function initialize(\ReflectionMethod $reflectionMethod, Request $request): void
    {
        $controllerName = sprintf('%s::%s', $reflectionMethod->getDeclaringClass()->getName(), $reflectionMethod->getName());

        try {
            $args = array_filter($reflectionMethod->getParameters(), fn (\ReflectionParameter $parameter) => $parameter->getName() === $this->value);
        } catch (\Error $error) {
            $annotationName = get_class($this);

            throw new InvalidArgumentException(sprintf('You need to inform the argument name for annotation "@%s" for controller "%s()"', $annotationName, $controllerName));
        }

        if (empty($args)) {
            throw new InvalidArgumentException(sprintf('No argument matches "%s" on controller %s', $this->value, $controllerName));
        }

        foreach ($this->constraints as $constraint) {
            if (!$constraint instanceof Constraint) {
                throw new InvalidArgumentException(
                    sprintf('Constraint option for controller "%s", argument "%s" should have a list of %s only', $controllerName, $this->value, Constraint::class)
                );
            }
        }

        $this->parameter = current($args);
        $this->required = !$this->parameter->allowsNull() && !$this->parameter->isDefaultValueAvailable();
    }
}

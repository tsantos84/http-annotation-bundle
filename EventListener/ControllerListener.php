<?php

namespace TSantos\HttpAnnotationBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\ArgumentResolver\CompositeResolver;
use TSantos\HttpAnnotationBundle\Exception\BadControllerSignatureException;
use TSantos\HttpAnnotationBundle\Exception\ConstraintViolationException;

class ControllerListener implements EventSubscriberInterface
{
    private CompositeResolver $registry;
    private Reader $reader;

    public function __construct(Reader $reader, CompositeResolver $registry)
    {
        $this->reader = $reader;
        $this->registry = $registry;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onController',
        ];
    }

    public function onController(ControllerEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $controller = $event->getController();
        $request = $event->getRequest();

        if (\is_array($controller)) {
            $reflectionMethod = new \ReflectionMethod($controller[0], $controller[1]);
        } elseif (\is_object($controller) && !$controller instanceof \Closure) {
            $reflectionMethod = (new \ReflectionObject($controller))->getMethod('__invoke');
        } else {
            $reflectionMethod = new \ReflectionFunction($controller);
        }

        $constraintViolations = new ConstraintViolationList();

        foreach ($this->reader->getMethodAnnotations($reflectionMethod) as $annotation) {
            if (!$annotation instanceof Annotation) {
                continue;
            }

            $annotation->initialize($reflectionMethod, $request);

            try {
                $this->registry->resolve($annotation, $request);
            } catch (ConstraintViolationException $violationException) {
                $constraintViolations->addAll($violationException->getViolations());
            }
        }

        if (count($constraintViolations)) {
            $this->resolveConstraintViolationArgument($reflectionMethod, $request, $constraintViolations);
        }
    }

    private function resolveConstraintViolationArgument(\ReflectionMethod $reflectionMethod, Request $request, ConstraintViolationList $constraintViolations): void
    {
        /** @var \ReflectionParameter[] $violationArguments */
        $violationArguments = array_filter(
            $reflectionMethod->getParameters(),
            fn (\ReflectionParameter $parameter) => $parameter->hasType() && ConstraintViolationListInterface::class === $parameter->getType()->getName()
        );

        // there is no argument, so we can throw bad request automatically
        if (0 === count($violationArguments)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        // more than one argument type-hinted, we can't guess which one should be resolved
        if (1 < count($violationArguments)) {
            throw new BadControllerSignatureException($reflectionMethod);
        }

        // only one argument type-hinted, so we can resolve it normally
        $argument = current($violationArguments);
        $request->attributes->set($argument->getName(), $constraintViolations);
    }
}

<?php

namespace TSantos\HttpAnnotationBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\ArgumentResolverRegistry;

class ControllerListener implements EventSubscriberInterface
{
    private ArgumentResolverRegistry $registry;
    private Reader $reader;

    public function __construct(Reader $reader, ArgumentResolverRegistry $registry)
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

        if (is_array($controller)) {
            $reflectionMethod = new \ReflectionMethod($controller[0], $controller[1]);
        }

        foreach ($this->reader->getMethodAnnotations($reflectionMethod) as $annotation) {
            if (!$annotation instanceof Annotation) {
                continue;
            }

            $annotation->initialize($reflectionMethod, $request);

            $this->registry->convert($annotation, $request);
        }
    }
}

<?php

namespace TSantos\HttpAnnotationBundle;

use Symfony\Component\HttpFoundation\Request;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Converter\ConverterInterface;

class ConverterRegistry implements ConverterInterface, \Countable
{
    /** @var ConverterInterface[] */
    private array $converters = [];

    public function __construct(iterable $converters)
    {
        foreach ($converters as $converter) {
            $this->add($converter);
        }
    }

    public function add(ConverterInterface $converter): void
    {
        if ($converter === $this) {
            return;
        }

        $this->converters[] = $converter;
    }

    public function count()
    {
        return count($this->converters);
    }

    public function convert(Annotation $annotation, Request $request): void
    {
        foreach ($this->converters as $converter) {
            if ($converter->supports($annotation, $request)) {
                $converter->convert($annotation, $request);

                return;
            }
        }

        throw new \LogicException();
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        foreach ($this->converters as $converter) {
            if ($converter->supports($annotation, $request)) {
                return true;
            }
        }

        return false;
    }
}

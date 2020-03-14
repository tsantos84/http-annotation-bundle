<?php

namespace TSantos\HttpAnnotationBundle\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;

class CompositeResolver implements ArgumentResolverInterface, \Countable
{
    /** @var ArgumentResolverInterface[] */
    private array $resolvers = [];

    public function __construct(iterable $converters)
    {
        foreach ($converters as $converter) {
            $this->add($converter);
        }
    }

    public function add(ArgumentResolverInterface $resolver): void
    {
        if ($resolver === $this) {
            return;
        }

        $this->resolvers[] = $resolver;
    }

    public function count()
    {
        return count($this->resolvers);
    }

    public function resolve(Annotation $annotation, Request $request): void
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->supports($annotation, $request)) {
                $resolver->resolve($annotation, $request);

                return;
            }
        }

        throw new \LogicException();
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->supports($annotation, $request)) {
                return true;
            }
        }

        return false;
    }
}

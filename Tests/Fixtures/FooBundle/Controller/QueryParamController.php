<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\Controller;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use TSantos\HttpAnnotationBundle\Annotations\QueryParam;

class QueryParamController
{
    /**
     * @Route("/query/required")
     * @QueryParam("foo")
     */
    public function required(string $foo): Response
    {
        return new Response($foo);
    }

    /**
     * @Route("/query/constraint")
     * @QueryParam("foo", constraints={
     *     @Assert\Length(max=2)
     * })
     */
    public function constraint(string $foo): Response
    {
        return new Response($foo);
    }

    /**
     * @Route("/query/optional")
     * @QueryParam("foo")
     */
    public function optional(string $foo = 'bar'): Response
    {
        return new Response($foo);
    }

    /**
     * @Route("/query/bag")
     * @QueryParam("query")
     */
    public function all(ParameterBag $query): Response
    {
        return new Response(json_encode($query->all()));
    }
}

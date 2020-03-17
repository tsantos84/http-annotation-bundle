<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TSantos\HttpAnnotationBundle\Annotations\QueryParam;

final class ActionController
{
    /**
     * @Route("/invoke")
     *
     * @QueryParam("foo")
     */
    public function __invoke(string $foo): Response
    {
        return new Response($foo);
    }
}

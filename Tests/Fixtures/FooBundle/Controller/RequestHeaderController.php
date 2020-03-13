<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\Controller;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use TSantos\HttpAnnotationBundle\Annotations\RequestHeader;

class RequestHeaderController
{
    /**
     * @Route("/header/required")
     * @RequestHeader("header", name="X-CUSTOM-HEADER")
     */
    public function required(string $header): Response
    {
        return new Response($header);
    }

    /**
     * @Route("/header/constraint")
     * @RequestHeader("foo", constraints={
     *     @Assert\Length(max=2)
     * })
     */
    public function constraint(string $foo): Response
    {
        return new Response($foo);
    }

    /**
     * @Route("/header/optional")
     * @RequestHeader("header", name="X-CUSTOM-HEADER")
     */
    public function optional(?string $header): Response
    {
        return new Response('ok');
    }

    /**
     * @Route("/header/bag")
     * @RequestHeader("headers")
     */
    public function bag(HeaderBag $headers): Response
    {
        return new Response('foo');
    }
}

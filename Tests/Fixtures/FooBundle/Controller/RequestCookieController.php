<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\Controller;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use TSantos\HttpAnnotationBundle\Annotations\RequestCookie;

class RequestCookieController
{
    /**
     * @Route("/cookie/required")
     * @RequestCookie("cookie", name="cookie.name")
     */
    public function required(string $cookie): Response
    {
        return new Response($cookie);
    }

    /**
     * @Route("/cookie/constraint")
     * @RequestCookie("foo", constraints={
     *     @Assert\Length(max=2)
     * })
     */
    public function constraint(string $foo): Response
    {
        return new Response($foo);
    }

    /**
     * @Route("/cookie/optional")
     * @RequestCookie("cookie", name="cookie.name")
     */
    public function optional(?string $cookie): Response
    {
        return new Response('ok');
    }

    /**
     * @Route("/cookie/bag")
     * @RequestCookie("cookies")
     */
    public function bag(ParameterBag $cookies): Response
    {
        return new Response('foo');
    }
}

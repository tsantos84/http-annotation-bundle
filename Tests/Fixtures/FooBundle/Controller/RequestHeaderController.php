<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\Controller;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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

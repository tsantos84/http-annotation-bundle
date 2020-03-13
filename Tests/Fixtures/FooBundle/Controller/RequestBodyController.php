<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TSantos\HttpAnnotationBundle\Annotations\RequestBody;
use TSantos\HttpAnnotationBundle\Tests\Fixtures\Model\Foo;

/**
 * Class FooController.
 */
class RequestBodyController
{
    /**
     * @Route("/body/required", methods={"POST"})
     * @RequestBody("body")
     */
    public function stringRequired(string $body): Response
    {
        return new Response($body);
    }

    /**
     * @Route("/body/optional", methods={"POST"})
     * @RequestBody("body")
     */
    public function stringOptional(?string $body): Response
    {
        return new Response('ok');
    }

    /**
     * @Route("/body/json", methods={"POST"})
     * @RequestBody("body")
     */
    public function json(array $body): Response
    {
        return new JsonResponse($body);
    }

    /**
     * @Route("/body/complex", methods={"POST"})
     * @RequestBody("foo")
     */
    public function complex(Foo $foo): Response
    {
        return new Response($foo->getFoo());
    }
}

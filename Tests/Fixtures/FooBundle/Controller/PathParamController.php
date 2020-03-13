<?php

namespace TSantos\HttpAnnotationBundle\Tests\Fixtures\FooBundle\Controller;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use TSantos\HttpAnnotationBundle\Annotations\PathParam;

class PathParamController
{
    /**
     * @Route("/path/required/{id}")
     * @PathParam("id")
     */
    public function required(string $id): Response
    {
        return new Response($id);
    }

    /**
     * @Route("/path/constraint/{id}")
     * @PathParam("id", constraints={
     *     @Assert\Length(max=2)
     * })
     */
    public function constraint(string $id): Response
    {
        return new Response($id);
    }

    /**
     * @Route("/path/optional/{id}")
     * @PathParam("id")
     */
    public function optional(?string $id): Response
    {
        return new Response($id);
    }

    /**
     * @Route("/path/bag/{id}")
     * @PathParam("paths")
     */
    public function bag(ParameterBag $paths): Response
    {
        return new Response(json_encode(['id' => $paths->get('id')]));
    }
}

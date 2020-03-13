<?php

namespace TSantos\HttpAnnotationBundle\Converter;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;
use TSantos\HttpAnnotationBundle\Annotations\Annotation;
use TSantos\HttpAnnotationBundle\Annotations\QueryParam;

class QueryParamConverter implements ConverterInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function convert(Annotation $annotation, Request $request): void
    {
        if (ParameterBag::class === $annotation->parameter->getType()->getName()) {
            $request->attributes->set($annotation->value, $request->query);

            return;
        }

        $params = $request->query->all();

        if (isset($params[$annotation->name])) {

            $value = $request->query->get($annotation->name);

            if (!empty($annotation->constraints)) {
                $result = $this->validator->validate($value, $annotation->constraints);

                if ($result->count()) {
                    throw new HttpException(400);
                }
            }

            $request->attributes->set($annotation->value, $value);

            return;
        }

        if (!$annotation->required) {
            return;
        }

        throw new HttpException(Response::HTTP_BAD_REQUEST, sprintf('Missing required query param "%s"', $annotation->name));
    }

    public function supports(Annotation $annotation, Request $request): bool
    {
        return $annotation instanceof QueryParam;
    }
}

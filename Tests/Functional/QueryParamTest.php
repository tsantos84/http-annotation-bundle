<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

/**
 * @internal
 * @coversNothing
 */
class QueryParamTest extends AbstractFunctionalTest
{
    public function testRequired(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/query/required?foo=bar');
        $this->assertSame('bar', $crawler->text());
    }

    public function testConstraint(): void
    {
        $client = self::createClient();
        $client->request('GET', '/query/constraint?foo=bar');
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }

    public function testSingleConstraintArgument(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/query/constraint/single?foo=bar');
        $this->assertSame('1', $crawler->text());
    }

    public function testMultipleConstraintArgument(): void
    {
        $client = self::createClient();
        $client->request('GET', '/query/constraint/multiple?foo=bar');
        $this->assertSame(500, $client->getResponse()->getStatusCode());
    }

    public function testOptional(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/query/optional');
        $this->assertSame('bar', $crawler->text());
    }

    public function testBag(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/query/bag?foo=foo&bar=bar');
        $this->assertSame('{"foo":"foo","bar":"bar"}', $crawler->text());
    }
}

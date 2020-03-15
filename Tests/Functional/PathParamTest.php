<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

/**
 * @internal
 * @coversNothing
 */
class PathParamTest extends AbstractFunctionalTest
{
    public function testRequired(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/path/required/foo');
        $this->assertSame('foo', $crawler->text());
    }

    public function testConstraint(): void
    {
        $client = self::createClient();
        $client->request('GET', '/path/constraint/foo');
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }

    public function testOptional(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/path/optional/foo');
        $this->assertSame('foo', $crawler->text());
    }

    public function testBag(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/path/bag/foo');
        $this->assertSame('{"id":"foo"}', $crawler->text());
    }
}

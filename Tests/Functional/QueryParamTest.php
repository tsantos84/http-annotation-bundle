<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

/**
 * @internal
 * @coversNothing
 */
class QueryParamTest extends AbstractFunctionalTest
{
    public function testRequired()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/query/required?foo=bar');
        $this->assertSame('bar', $crawler->text());
    }

    public function testConstraint()
    {
        $client = self::createClient();
        $client->request('GET', '/query/constraint?foo=bar');
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }

    public function testOptional()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/query/optional');
        $this->assertSame('bar', $crawler->text());
    }

    public function testBag()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/query/bag?foo=foo&bar=bar');
        $this->assertSame('{"foo":"foo","bar":"bar"}', $crawler->text());
    }
}

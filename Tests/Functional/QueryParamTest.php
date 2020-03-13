<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class QueryParamTest extends WebTestCase
{
    public function testRequired()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/query/required?foo=bar');
        $this->assertSame('bar', $crawler->text());
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

<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class PathParamTest extends WebTestCase
{
    public function testRequired()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/path/required/foo');
        $this->assertSame('foo', $crawler->text());
    }

    public function testConstraint()
    {
        $client = self::createClient();
        $client->request('GET', '/path/constraint/foo');
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }

    public function testOptional()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/path/optional/foo');
        $this->assertSame('foo', $crawler->text());
    }

    public function testBag()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/path/bag/foo');
        $this->assertSame('{"id":"foo"}', $crawler->text());
    }
}

<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

/**
 * @internal
 * @coversNothing
 */
class RequestHeaderTest extends AbstractFunctionalTest
{
    public function testRequired()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/header/required', [], [], [
            'HTTP_X-CUSTOM-HEADER' => 'foo',
        ]);
        $this->assertSame('foo', $crawler->text());
    }

    public function testConstraint()
    {
        $client = self::createClient();
        $client->request('GET', '/header/constraint', [], [], [
            'HTTP_X-CUSTOM-HEADER' => 'foo',
        ]);
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }

    public function testOptional()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/header/optional');
        $this->assertSame('ok', $crawler->text());
    }

    public function testBag()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/header/bag', [], [], [
            'HTTP_X-CUSTOM-HEADER' => 'foo',
        ]);
        $this->assertSame('foo', $crawler->text());
    }
}

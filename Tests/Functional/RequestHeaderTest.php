<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class RequestHeaderTest extends WebTestCase
{
    public function testRequired()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/header/required', [], [], [
            'HTTP_X-CUSTOM-HEADER' => 'foo',
        ]);
        $this->assertSame('foo', $crawler->text());
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

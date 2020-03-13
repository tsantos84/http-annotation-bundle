<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;

/**
 * @internal
 * @coversNothing
 */
class RequestCookieTest extends WebTestCase
{
    public function testRequired()
    {
        $client = self::createClient();
        $client->getCookieJar()->set(new Cookie('cookie.name', 'foo'));
        $crawler = $client->request('GET', '/cookie/required');
        $this->assertSame('foo', $crawler->text());
    }

    public function testOptional()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/cookie/optional');
        $this->assertSame('ok', $crawler->text());
    }

    public function testBag()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/cookie/bag', [], [], [
            'HTTP_X-CUSTOM-HEADER' => 'foo',
        ]);
        $this->assertSame('foo', $crawler->text());
    }
}

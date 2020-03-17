<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional;

/**
 * @internal
 * @coversNothing
 */
class InvokeControllerTest extends AbstractFunctionalTest
{
    public function testInvoke(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/invoke?foo=foo');
        $this->assertSame('foo', $crawler->text());
    }
}

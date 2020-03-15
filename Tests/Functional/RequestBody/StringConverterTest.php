<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional\RequestBody;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class StringConverterTest extends WebTestCase
{
    public function testRequired(): void
    {
        $client = self::createClient();
        $crawler = $client->request('POST', '/body/required', [], [], [], '{"foo":"bar"}');
        $this->assertSame('{"foo":"bar"}', $crawler->text());
    }

    public function testOptional(): void
    {
        $client = self::createClient();
        $crawler = $client->request('POST', '/body/optional');
        $this->assertSame('ok', $crawler->text());
    }
}

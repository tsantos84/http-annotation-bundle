<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional\RequestBody;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class ComplexTypeConverterTest extends WebTestCase
{
    public function testRequired()
    {
        $client = self::createClient();
        $client->request('POST', '/body/complex', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], '{"foo":"foo", "bar":"bar", "baz":"baz"}');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}

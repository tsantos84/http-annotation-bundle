<?php

namespace TSantos\HttpAnnotationBundle\Tests\Functional\RequestBody;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 * @coversNothing
 */
class JsonConverterTest extends WebTestCase
{
    public function testJsonBody(): void
    {
        $client = self::createClient();
        $client->request('POST', '/body/json', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], '{"foo":"bar"}');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}

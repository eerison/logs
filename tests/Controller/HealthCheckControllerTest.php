<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HealthCheckControllerTest extends WebTestCase
{
    /**
     * @test
     * @testdox it's getting a successful response from health check endpoint.
     * @group functional
     */
    public function testSuccessResponse(): void
    {
        $client = static::createClient();

        $client->request('GET', '/healthcheck');
        $this->assertResponseIsSuccessful();
    }
}
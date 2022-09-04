<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogCountControllerTest extends WebTestCase
{
    /**
     * @test
     * @testdox it's returning a successful response for /log/count endpoint.
     * @group functional
     */
    public function successfulResponse()
    {
        $client = static::createClient();
        $client->request('GET', '/log/count');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @test
     * @testdox it's checking if the /log/count response's body has count field.
     */
    public function thereIsCount()
    {
        $client = static::createClient();
        $client->request('GET', '/log/count');
        $content = $client->getResponse()->getContent();

        $this->assertJson($content);

        $contentJson = json_decode($content, JSON_PRETTY_PRINT);
        $this->assertArrayHasKey('count', $contentJson);
    }
}
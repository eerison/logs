<?php

namespace Tests\Parse;

use App\Parse\LogProviderAParseLog;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class LogProviderAParseTest extends TestCase
{
    /**
     * @test
     * @testdox It's parsing the logs from providerA to an array.
     * @group unit
     */
    public function parse(): void
    {
        $serializer = new Serializer([new GetSetMethodNormalizer(), new ArrayDenormalizer()]);
        $parse = new LogProviderAParseLog($serializer);
        $log = $parse->parse('USER-SERVICE - - [17/Aug/2021:09:21:53 +0000] "POST /users HTTP/1.1" 201');

        $this->assertEquals('USER-SERVICE', $log->getServiceName());
        $this->assertEquals(new \DateTime('2021-08-17T09:21:53.000000+0000'), $log->getDate());
        $this->assertEquals('POST', $log->getHttpMethod());
        $this->assertEquals(201, $log->getHttpStatusCode());
        $this->assertEquals('/users', $log->getUrl());

    }
}
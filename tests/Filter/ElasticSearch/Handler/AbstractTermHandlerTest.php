<?php

namespace Tests\Filter\ElasticSearch\Handler;

use App\Filter\ElasticSearch\Handler\HandlerInterface;
use App\Filter\ElasticSearch\Handler\ServiceName;
use Elastica\Query\BoolQuery;
use Monolog\Test\TestCase;

class AbstractTermHandlerTest extends TestCase
{
    /**
     * @test
     * @testdox It's checking if "queryParam" exist into the query
     * @group unit
     */
    public function serviceNameQueryParams(): void
    {
        $bollQuery = $this->createMock(BoolQuery::class);
        $nextHandler = $this->createMock(HandlerInterface::class);
        $nextHandler
            ->expects($this->once())
            ->method('handle');

        $serviceNameHandler = $this->createPartialMock(ServiceName::class, ['term']);
        $serviceNameHandler
            ->expects($this->once())
            ->method('term')
            ->with($this->equalTo('bar'));
        $serviceNameHandler->setNext($nextHandler);
        $serviceNameHandler->handle($bollQuery, ['serviceName' => 'bar']);
    }

    /**
     * @test
     * @testdox It isn't adding param's query, when the field is not passed into the queryParams.
     * @group unit
     */
    public function serviceNameDoesNotExist()
    {
        $bollQuery = $this->createMock(BoolQuery::class);
        $bollQuery
            ->expects($this->never())
            ->method($this->anything());

        $nextHandler = $this->createMock(HandlerInterface::class);
        $nextHandler
            ->expects($this->once())
            ->method('handle');

        $serviceNameHandler = $this->createPartialMock(ServiceName::class, ['term']);
        $serviceNameHandler
            ->expects($this->never())
            ->method('term');

        $serviceNameHandler->setNext($nextHandler);
        $serviceNameHandler->handle($bollQuery, ['foo' => 'bar']);
    }
}
<?php

namespace Tests\Filter\ElasticSearch;

use App\Filter\ElasticSearch\ElasticSearchFilter;
use App\Filter\ElasticSearch\Handler\HandlerInterface;
use ArrayObject;
use Elastica\Query\BoolQuery;
use PHPUnit\Framework\TestCase;

class ElasticSearchFilterTest extends TestCase
{
    /**
     * @test
     * @testdox It's checking if the chain are connected between each other properly and if it's called.
     * @group unit
     */
    public function testChain(): void
    {
        //Mock
        $boolQuery = $this->createMock(BoolQuery::class);

        $handler2 = $this->createMock(HandlerInterface::class);
        $handler2
            ->expects($this->never())
            ->method('handle')
            ->with($boolQuery, ['foo' => 'bar']);
        $handler2
            ->expects($this->never())
            ->method('setNext');

        $handler1 = $this->createMock(HandlerInterface::class);
        $handler1
            ->expects($this->once())
            ->method('handle')
            ->with($boolQuery, ['foo' => 'bar']);
        $handler1
            ->expects($this->once())
            ->method('setNext')
            ->with($handler2);

        //Run code
        $elasticSearchFilter = $this
            ->getMockBuilder(ElasticSearchFilter::class)
            ->onlyMethods(['boolQuery'])
            ->setConstructorArgs([new ArrayObject([$handler1, $handler2])])
            ->getMock();

        $elasticSearchFilter
            ->method('boolQuery')
            ->willReturn($boolQuery);
        $elasticSearchFilter->createQuery(['foo' => 'bar']);
    }
}
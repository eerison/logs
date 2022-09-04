<?php

namespace Tests\Filter\ElasticSearch\Handler;

use App\Filter\ElasticSearch\Handler\HttpStatusCode;
use App\Filter\ElasticSearch\Handler\ServiceName;
use Elastica\Query\BoolQuery;
use PHPUnit\Framework\TestCase;

class SmokeTermHandlerTest extends TestCase
{
    /**
     * @test
     * @testdox it's checking if the fields name are correct for each term's handler.
     * @dataProvider getProvidedData
     * @group unit
     */
    public function checkIfTermHandlers(string $class, string $field): void
    {
        $boolQuery = $this->createMock(BoolQuery::class);

        $handler = $this->createPartialMock($class, ['term']);
        $handler
            ->expects($this->once())
            ->method('term')
            ->with('bar');
        $handler->handle($boolQuery, [$field => 'bar']);
    }

    public function getProvidedData(): array
    {
        return [
          [ServiceName::class, 'serviceName'],
          [HttpStatusCode::class, 'httpStatusCode'],
        ];
    }
}
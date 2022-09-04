<?php

namespace Tests\Filter\ElasticSearch\Handler;

use App\Filter\ElasticSearch\Handler\DateRange;
use Elastica\Query\BoolQuery;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    /**
     * @test
     * @testdox it's creating a date range filter with start date only.
     * @group unit
     */
    public function createQueryWithDateStart(): void
    {
        $boolQuery = $this->createMock(BoolQuery::class);
        $filter = $this->createPartialMock(DateRange::class, ['range']);
        $filter
            ->expects($this->once())
            ->method('range')
            ->with(['gte' => '2000-01-01']);
        $filter->handle($boolQuery, ['startDate' => '2000-01-01']);
    }

    /**
     * @test
     * @testdox it is passing range field to DateRange filter.
     * @testWith ["startDate", true, "gte"]
     *           ["endDate", true, "lte"]
     * @group unit
     */
    public function withoutStartDate(string $field, bool $shouldContain, string $rangeField): void
    {
        //Mock
        $boolQuery = $this->createMock(BoolQuery::class);
        $boolQuery
            ->expects($this->once())
            ->method('addMust');

        $filter = $this->createPartialMock(DateRange::class, ['range']);
        $filter
            ->expects($this->once())
            ->method('range')
            ->with($this->callback(
                fn(array $values): bool => $shouldContain == array_key_exists($rangeField, $values)
            ));
        $filter->handle($boolQuery, [$field => '2000-01-01']);
    }

    /**
     * @test
     * @testdox it's checking when there isn't startDate and endDate, the range method is not executed.
     * @testWith [{"startDate": "foo", "endDate": "bar"}, 1]
     *           [{"startDate2": "foo", "endDate": "bar"}, 1]
     *           [{"startDate": "foo", "endDate2": "bar"}, 1]
     *           [{"startDate2": "foo", "endDate2": "bar"}, 0]
     *           [{"startDate2": "foo"}, 0]
     *           [{}, 0]
     * @group unit
     */
    public function callRangeMethod(array $params, int $call): void
    {
        $boolQuery = $this->createMock(BoolQuery::class);
        $filter = $this->createPartialMock(DateRange::class, ['range']);
        $filter
            ->expects($this->exactly($call))
            ->method('range');
        $filter->handle($boolQuery, $params);
    }


    /**
     * @test
     * @testdox if there aren't start and end date, the query should never be executed.
     * @group unit
     */
    public function neverExecuteRangeAndQuery(): void
    {
        $boolQuery = $this->createMock(BoolQuery::class);
        $boolQuery
            ->expects($this->never())
            ->method('addMust');
        $filter = $this->createPartialMock(DateRange::class, ['range']);
        $filter
            ->expects($this->never())
            ->method('range');
        $filter->handle($boolQuery, []);
    }
}
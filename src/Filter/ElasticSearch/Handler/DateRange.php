<?php

namespace App\Filter\ElasticSearch\Handler;

use Elastica\Query\BoolQuery;
use Elastica\Query\Range;

class DateRange extends AbstractHandler
{
    private const FIELD_NAME = 'date';

    public function handle(BoolQuery $boolQuery, array $queryParams): void
    {
        $params = [];

        if (array_key_exists('startDate', $queryParams)) {
            $params['gte'] = $queryParams['startDate'];
        }

        if (array_key_exists('endDate', $queryParams)) {
            $params['lte'] = $queryParams['endDate'];
        }

        if ([] !== $params) {
            $range = $this->range($params);
            $boolQuery->addMust($range);
        }

        parent::handle($boolQuery, $queryParams);
    }

    protected function range($params): Range
    {
        return new Range(self::FIELD_NAME, $params);
    }
}
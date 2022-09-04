<?php

namespace App\Filter\ElasticSearch\Handler;

use Elastica\Query\BoolQuery;
use Elastica\Query\Term;

abstract class AbstractTermHandler extends AbstractHandler
{
    abstract protected function queryParamKey(): string;

    public function handle(BoolQuery $boolQuery, array $queryParams): void
    {
        if (array_key_exists($this->queryParamKey(), $queryParams)) {
            $serviceNameQuery = $this->term($queryParams[$this->queryParamKey()]);
            $boolQuery->addMust($serviceNameQuery);
        }

        parent::handle($boolQuery, $queryParams);
    }

    protected function term(string $value): Term
    {
        return (new Term([$this->queryParamKey() => $value]));
    }
}
<?php

namespace App\Filter\ElasticSearch\Handler;

use Elastica\Query\BoolQuery;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(tags: ['app.elastic_search_filter'])]
interface HandlerInterface
{
    public function setNext(HandlerInterface $handler): HandlerInterface;

    public function handle(BoolQuery $boolQuery, array $queryParams): void;

}
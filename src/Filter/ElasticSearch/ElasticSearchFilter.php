<?php

namespace App\Filter\ElasticSearch;

use Elastica\Query\BoolQuery;
use Generator;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

/**
 * I'm using Chain of Responsibility partner
 * https://refactoring.guru/design-patterns/chain-of-responsibility
 */
class ElasticSearchFilter
{
    public function __construct(#[TaggedIterator('app.elastic_search_filter')] private readonly iterable $handlers){}

    public function createQuery(array $queryParams): BoolQuery
    {
        /** @var Generator $handlers */
        $handlers = $this->handlers->getIterator();

        $handlers->rewind();
        $firstHandler = $handlers->current();

        //Here I'm just connecting handlers into the chain.
        while ($handlers->valid()) {
            $currentHandler = $handlers->current();
            $handlers->next();
            $nextHandler = $handlers->current();

            if ($nextHandler) {
                $currentHandler->setNext($nextHandler);
            }
        }

        //here I'm starting the chain from the first element.
        $bollQuery = $this->boolQuery();
        $firstHandler->handle($bollQuery, $queryParams);

        return $bollQuery;
    }

    protected function boolQuery(): BoolQuery
    {
        return new BoolQuery();
    }

}
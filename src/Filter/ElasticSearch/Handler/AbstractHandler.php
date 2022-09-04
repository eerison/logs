<?php

namespace App\Filter\ElasticSearch\Handler;

use Elastica\Query\BoolQuery;

abstract class AbstractHandler implements HandlerInterface
{
    private ?HandlerInterface $nextHandler = null;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(BoolQuery $boolQuery, array $queryParams): void
    {
        if (null === $this->nextHandler) {
            return;
        }

        $this->nextHandler->handle($boolQuery, $queryParams);
    }
}
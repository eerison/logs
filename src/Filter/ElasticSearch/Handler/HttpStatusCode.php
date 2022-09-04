<?php

namespace App\Filter\ElasticSearch\Handler;

class HttpStatusCode extends AbstractTermHandler
{
    protected function queryParamKey(): string
    {
        return 'httpStatusCode';
    }
}
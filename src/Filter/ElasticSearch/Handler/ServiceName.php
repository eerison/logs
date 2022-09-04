<?php

namespace App\Filter\ElasticSearch\Handler;

class ServiceName extends AbstractTermHandler
{
    protected function queryParamKey(): string
    {
        return 'serviceName';
    }
}
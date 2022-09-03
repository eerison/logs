<?php

namespace App\Parse;

use App\Entity\Log;
use DateTime;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class LogProviderAParseLog implements LogStringParseInterface
{
    public function __construct(private readonly DenormalizerInterface $denormalizer)
    {
    }

    public function parse(string $content): Log
    {
        $matches = [];
        $partener = '/(?P<serviceName>.*) - - \[(?P<dateString>[\d\/\w: +]+)] \"(?P<httpMethod>\w+) (?<url>.*) .*" (?P<httpStatusCodeString>\d+)/';

        preg_match($partener, $content, $matches);

        return $this->denormalizer->denormalize($matches, Log::class);
    }
}
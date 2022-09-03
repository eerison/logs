<?php

namespace App\Parse;

use App\Entity\Log;

interface LogStringParseInterface
{
    public function parse(string $content): Log;
}

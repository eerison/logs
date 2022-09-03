<?php

namespace App\Message;

class LogMessage
{
     public function __construct(private readonly string $row)
     {
     }

    public function getRow(): string
    {
        return $this->row;
    }
}

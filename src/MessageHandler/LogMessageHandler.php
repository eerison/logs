<?php

namespace App\MessageHandler;

use App\Message\LogMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class LogMessageHandler implements MessageHandlerInterface
{
    public function __invoke(LogMessage $message): void
    {
        echo $message->getRow();
    }
}

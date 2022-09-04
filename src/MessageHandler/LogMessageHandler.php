<?php

namespace App\MessageHandler;

use App\Message\LogMessage;
use App\Parse\LogStringParseInterface;
use App\Repository\LogRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class LogMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly LogStringParseInterface $logStringParse,
        private readonly LogRepository $logRepository
    ) {}

    public function __invoke(LogMessage $message): void
    {
        $logRow = $message->getRow();
        $log = $this->logStringParse->parse($logRow);

        $this->logRepository->persist($log);
        $this->logRepository->flush();
    }
}

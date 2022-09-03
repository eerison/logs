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

        /**
         * TODO here there is a problem, because for each log I'm going persisting into the database, in other words it will be like a DDOS attack to my database.
         *      What I thought to solve this is:
         *          let this handler to parse the logs and somehow create chunks into the queue(e.g 10k logs per chunk, it's just an example I can get this from .env),
         *          and create other Handler to consume those chunks and save into the database.
         */
        $this->logRepository->persist($log);
        $this->logRepository->flush();
    }
}

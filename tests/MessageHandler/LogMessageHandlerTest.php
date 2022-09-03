<?php

namespace Tests\MessageHandler;

use App\Entity\Log;
use App\Message\LogMessage;
use App\MessageHandler\LogMessageHandler;
use App\Parse\LogStringParseInterface;
use App\Repository\LogRepository;
use Monolog\Test\TestCase;

class LogMessageHandlerTest extends TestCase
{
    /**
     * @test
     * @testdox It's consuming logs from queue and saving into the database.
     */
    public function consumeDataFromQueue(): void
    {
        //Mock
        $logMessage = $this->createMock(LogMessage::class);
        $logMessage
            ->expects($this->once())
            ->method('getRow')
            ->willReturn('log row foo');

        $logStringParse = $this->createMock(LogStringParseInterface::class);
        $logStringParse
            ->expects($this->once())
            ->method('parse')
            ->willReturn(new Log())
            ->with($this->equalTo('log row foo'));

        $logRepository = $this->createMock(LogRepository::class);
        $logRepository
            ->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Log::class));
        $logRepository
            ->expects($this->once())
            ->method('flush');

        //Run code
        $handler = new LogMessageHandler($logStringParse, $logRepository);
        $handler($logMessage);
    }
}
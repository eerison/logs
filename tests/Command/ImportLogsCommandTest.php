<?php

namespace Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ImportLogsCommandTest extends KernelTestCase
{
    private readonly Application $application;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $this->application = new Application(static::$kernel);
    }

    /**
     * @test
     * @testdox It's checking if the file path exist.
     * @testWith ["foo.txt", 1]
     *           ["tests/Resources/logs.txt", 0]
     */
    public function testFilePath(string $filePath, int $commandStatusCode): void
    {
        $command = $this->application->find('app:import-logs');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filePath' => $filePath,
        ]);

        $this->assertEquals($commandStatusCode, $commandTester->getStatusCode());
    }

    /**
     * @test
     * @testdox it's checking if the logs row is passed to handler message.
     */
    public function passFileToHandlerMessage(): void
    {
        $command = $this->application->find('app:import-logs');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'filePath' => 'tests/Resources/logs.txt',
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}

<?php

namespace App\Command;

use App\Message\LogMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:import-logs',
    description: 'Add a short description for your command',
)]
class ImportLogsCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filePath', InputArgument::REQUIRED, 'Inform the file path, e.g: ~/logs.txt')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('filePath');

        if (!file_exists($filePath)) {
            $io->error(sprintf('File %s not found', $filePath));
            return Command::FAILURE;
        }

        $this->messageBus->dispatch(new LogMessage('Look! I created a message!'));
        $io->success('Your logs were added into the queue!');
        return Command::SUCCESS;
    }
}

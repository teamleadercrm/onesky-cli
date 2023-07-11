<?php

namespace Teamleader\OneSky;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('init')
            ->setDescription('Create empty ' . self::FILENAME . ' configuration file');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        // Empty initialized.
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (file_exists(self::FILENAME)) {
            $output->writeln('<error>Configuration file already exists</error>');

            return self::FAILURE;
        }

        file_put_contents(self::FILENAME, file_get_contents(__DIR__ . '/stubs/' . self::FILENAME));
        $output->writeln('<info>Created ' . self::FILENAME . '</info>');

        return self::SUCCESS;
    }
}

<?php

namespace Teamleader\OneSky;

use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Create empty'.self::FILENAME.' configuration file');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        // Empty initialized.
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (file_exists(self::FILENAME)) {
            $output->writeln('<error>Configuration file already exists</error>');
            return;
        }

        file_put_contents(self::FILENAME, file_get_contents(__DIR__.'/stubs/'.self::FILENAME));
        $output->writeln('<info>Created '.self::FILENAME.'</info>');
    }
}

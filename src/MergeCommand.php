<?php

namespace Teamleader\OneSky;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MergeCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('merge')
            ->setDescription('Merge downloaded PHP translations into one another ')
            ->addArgument('files', InputArgument::IS_ARRAY, 'list of PHP translation files to merge');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string[] $files */
        $files = $input->getArgument('files');

        $merged = [];

        foreach ($files as $file) {
            $translations = include $file;
            $merged = array_merge($translations, $merged);
        }

        echo '<?php ' . PHP_EOL . 'return ';
        var_export($merged);
        echo ';';

    }
}

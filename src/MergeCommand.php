<?php

namespace Teamleader\OneSky;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Teamleader\OneSky\Merge\Format;
use Teamleader\OneSky\Merge\JsonTranslationFileIoStrategy;
use Teamleader\OneSky\Merge\PhpTranslationFileIoStrategy;
use Teamleader\OneSky\Merge\TranslationMerger;

class MergeCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('merge')
            ->setDescription('Merge downloaded PHP translations into one another ')
            ->addOption(
                'format',
                'f',
                InputArgument::OPTIONAL,
                'the format in which input and ouput translations are formatted (JSON or PHP)',
                Format::FORMAT_PHP
            )
            ->addArgument('files', InputArgument::IS_ARRAY, 'list of PHP translation files to merge');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        switch (Format::fromString($input->getOption('format'))) {
            case Format::php():
                $translationFileIoStrategy = new PhpTranslationFileIoStrategy();
                break;
            case Format::json():
                $translationFileIoStrategy = new JsonTranslationFileIoStrategy();
                break;
        }

        $translationMerger = new TranslationMerger($translationFileIoStrategy);
        echo $translationMerger->merge($input->getArgument('files'));
    }
}

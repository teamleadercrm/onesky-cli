<?php

namespace Teamleader\OneSky;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UploadCommand extends Command
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->setName('upload')
            ->setDescription('Upload a translation file to OneSky')
            ->addOption('file_format', 'f', InputArgument::OPTIONAL,
                'A file type from this list: https://support.oneskyapp.com/hc/en-us/articles/205978508-File-formats-that-OneSky-supports. Defaults to the value in the onesky.yml file')
            ->addOption('is_keeping_all_strings', 'd', InputArgument::OPTIONAL,
                'Whether to remove strings no longer in the uploaded file (the \'d\' is for "deprecate"). Defaults to the value in the onesky.yml file')
            ->addArgument('locale', InputArgument::REQUIRED, 'Locale')
            ->addArgument('file', InputArgument::REQUIRED, 'File');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->initializeClient($input->getOption('key'), $input->getOption('secret'));

        $file_format = $input->getOption('file_format');
        if (is_null($file_format)) {
            $this->config['file_format'];
        }

        $is_keeping_all_strings = $input->getOption('is_keeping_all_strings');
        if (is_null($is_keeping_all_strings)) {
            $is_keeping_all_strings = $this->config['is_keeping_all_strings'];
        }

        $project_id = $input->getOption('project_id');
        if (is_null($project_id)) {
            $project_id = $this->config['project_id'];
        }

        $response = $this->client->files('upload', [
            'project_id' => (int) $project_id,
            'file' => $input->getArgument('file'),
            'file_format' => $file_format,
            'locale' => $input->getArgument('locale'),
            'is_keeping_all_strings' => $is_keeping_all_strings,
        ]);

        $data = json_decode($response, true);
        if (isset($data['meta']) && $data['meta']['status'] != 201) {
            $output->writeln('<error>' . $response . '</error>');

            return self::FAILURE;
        }

        $output->writeln('<info>File uploaded</info>');

        return self::SUCCESS;
    }
}

<?php

namespace Teamleader\OneSky;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UploadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('upload')
            ->setDescription('Upload a translation file to OneSky')
            ->addArgument('locale', InputArgument::REQUIRED, 'Locale')
            ->addArgument('file', InputArgument::REQUIRED, 'File')
			->addOption('file_format', 'f', InputArgument::OPTIONAL, 'A file type from this list: https://support.oneskyapp.com/hc/en-us/articles/205978508-File-formats-that-OneSky-supports. Defaults to the value in the onesky.yml file')
			->addOption('is_keeping_all_strings', 'k', InputArgument::OPTIONAL, 'Whether to remove strings no longer in the uploaded file. Defaults to the value in the onesky.yml file');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$file_format = $this->config['file_format'];
		if ($input->getOption('file_format')) {
			$file_format = $this->config['file_format'];
		}

		$is_keeping_all_strings = $this->config['is_keeping_all_strings'];
		if ($input->getOption('is_keeping_all_strings')) {
			$is_keeping_all_strings = $this->config['is_keeping_all_strings'];
		}

        $response = $this->client->files('upload', [
            'project_id' => (int) $this->config['project_id'],
            'file' => $input->getArgument('file'),
            'file_format' => $file_format,
            'locale' => $input->getArgument('locale'),
            'is_keeping_all_strings' => $is_keeping_all_strings,
        ]);

        $data = json_decode($response, true);
        if (isset($data['meta']) && $data['meta']['status'] != 201) {
            $output->writeln('<error>'.$response.'</error>');
            return;
        }

        $output->writeln('<info>File uploaded</info>');
    }
}

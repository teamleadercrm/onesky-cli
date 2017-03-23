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
            ->addArgument('file', InputArgument::REQUIRED, 'File');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->client->files('upload', [
            'project_id' => (int) $this->config['project_id'],
            'file' => $input->getArgument('file'),
            'file_format' => $this->config['file_format'],
            'locale' => $input->getArgument('locale'),
            'is_keeping_all_strings' => $this->config['is_keeping_all_strings'],
        ]);

        $data = json_decode($response, true);
        if (isset($data['meta']) && $data['meta']['status'] != 201) {
            $output->writeln('<error>'.$response.'</error>');
            return;
        }

        $output->writeln('<info>File uploaded</info>');
    }
}

<?php

namespace Teamleader\OneSky;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('download')
            ->setDescription('Download a translation file from OneSky')
            ->addArgument('locale', InputArgument::REQUIRED, 'Locale')
            ->addArgument('file', InputArgument::REQUIRED, 'File')
            ->addArgument('source_file_name', InputArgument::REQUIRED, 'Source file name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->initializeClient($input->getOption('key'), $input->getOption('secret'));

        $project_id = $input->getOption('project_id');
        if (is_null($project_id)) {
            $project_id = $this->config['project_id'];
        }

        $response = $this->client->translations('export', [
            'project_id' => (int) $project_id,
            'locale' => $input->getArgument('locale'),
            'source_file_name' => $input->getArgument('source_file_name'),
        ]);

        if (!$response) {
            $output->writeln('<error>Empty OneSky response!</error>');
            exit(1);
        }

        $data = json_decode($response, true);
        if (isset($data['meta']) && $data['meta']['status'] != 201) {
            $output->writeln('<error>' . $data['meta']['message'] . '</error>');
            exit(1);
        }

        file_put_contents($input->getArgument('file'), $response);
        $output->writeln('<info>Created ' . $input->getArgument('file') . '</info>');
    }
}

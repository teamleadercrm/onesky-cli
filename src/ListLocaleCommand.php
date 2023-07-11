<?php

namespace Teamleader\OneSky;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListLocaleCommand extends Command
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->setName('list-locale')
            ->setDescription('List the locale enabled in the project');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->initializeClient($input->getOption('key'), $input->getOption('secret'));

        $project_id = $input->getOption('project_id');
        if (is_null($project_id)) {
            $project_id = $this->config['project_id'];
        }

        $response = $this->client->projects('languages', [
            'project_id' => $project_id,
        ]);

        if (!$response) {
            $output->writeln('<error>Empty OneSky response!</error>');
            exit(1);
        }

        $data = json_decode($response, true);
        if (isset($data['meta']) && $data['meta']['status'] != 200) {
            $output->writeln('<error>' . $data['meta']['message'] . '</error>');
            exit(1);
        }

        foreach ($data['data'] as $language) {
            $output->writeln($language['code']);
        }

        return self::SUCCESS;
    }
}

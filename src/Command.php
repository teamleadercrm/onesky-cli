<?php

namespace Teamleader\OneSky;

use Exception;
use Onesky\Api\Client;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

abstract class Command extends BaseCommand
{
    const FILENAME = 'onesky.yml';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var Client
     */
    protected $client;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        if (! file_exists(self::FILENAME)) {
            $output->write('<error>'.self::FILENAME.' configuration file not found');
            return;
        }

        $this->config = Yaml::parse(file_get_contents(self::FILENAME));

        $this->client = new Client();
        $this->client
            ->setApiKey($this->config['key'])
            ->setSecret($this->config['secret']);
    }
}

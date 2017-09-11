<?php

namespace Teamleader\OneSky;

use Onesky\Api\Client;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
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

	protected function configure()
	{
		$this
			->addOption('key', 'k', InputArgument::OPTIONAL,
				'Your onesky key. Defaults to the value in the onesky.yml file')
			->
			addOption('secret', 's', InputArgument::OPTIONAL,
				'Your onesky secret. Defaults to the value in the onesky.yml file')
			->addOption('project_id', 'p', InputArgument::OPTIONAL,
				'Your onesky project_id. Defaults to the value in the onesky.yml file');
	}

	protected function initialize(InputInterface $input, OutputInterface $output)
	{
		$defaults = [
			'file_format' => 'HIERARCHICAL_JSON',
			'is_keeping_all_strings' => true,
		];

		if (file_exists(self::FILENAME)) {
			$this->config = array_merge($defaults, Yaml::parse(file_get_contents(self::FILENAME)));
		}
	}

	/**
	 * @param string $key onesky api key, defaults to value in config
	 * @param string $secret onesky api secret, defaults to value in config
	 */
	protected function initializeClient($key, $secret)
	{
		if (is_null($key)) {
			$key = $this->config['key'];
		}

		if (is_null($secret)) {
			$secret = $this->config['secret'];
		}

		$this->client = new Client();
		$this->client
			->setApiKey($key)
			->setSecret($secret);
	}
}

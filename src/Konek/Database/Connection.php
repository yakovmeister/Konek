<?php

namespace Yakovmeister\Konek\Database;

use \PDO;
use Yakovmeister\Konek\Configure\Config;

class Connection implements ConnectionInterface
{
	protected $connection;

	protected $query;

	protected $configuration;

	public function __construct(Config $config)
	{
		$this->configuration = $config;
	}

	public function setConnection()
	{
		$connection = $this->configuration->load('database')->use('default');
		
		switch($connection)
		{
			case "mysql":
				$this->connection = new \PDO(
					"mysql:dbname={$this->configuration->use($connection)['database']};host=$this->configuration->use('connections')[$connection]['host']",
					$this->configuration->use('connections')[$connection]['username'],
					$this->configuration->use('connections')[$connection]['password']);
				break;
			case "sqlite":
				$databasePath = !is_dir($this->configuration->use('connections')[$connection]['database']) 
								? root_path().DIRECTORY_SEPARATOR.$this->configuration->use('connections')[$connection]['database']
								: $this->configuration->use('connections')[$connection]['database'];

				$this->connection = new \PDO("sqlite:{$databasePath}");
				break;
		}

		return $this;
	}

	public function purgeConnection()
	{
		$this->connection = null;

		return $this;
	}

	public function hasConnection()
	{
		return isset($this->connection) && $this->connection instanceof \PDO;
	}

	public function getConnection()
	{
		return $this->connection;
	}
}
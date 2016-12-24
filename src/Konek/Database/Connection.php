<?php

namespace Yakovmeister\Konek\Database;

use \PDO;
use Yakovmeister\Konek\Configure\Config;

class Connection
{
	protected $connection;

	protected $query;

	protected $configuration;

	public function __construct(Config $config)
	{
		$this->configuration = $config;
	}

	/**
	 * set connection based on the configuration file provided
	 * @return $this
	 */
	public function setConnection()
	{
		$connection = $this->configuration->load('database')->use('default');
		
		switch($connection)
		{
			case "mysql":
			 	$connectionName = "mysql";
			 	$database = "dbname={$this->configuration->use('connections')[$connection]['database']}";
			 	$host = "host={$this->configuration->use('connections')[$connection]['host']}";
				$this->connection = new \PDO("{$connectionName}:{$database};{$host}",
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

		$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		return $this;
	}

	/**
	 * remove connection, set $this->connection to null
	 * @return [type] [description]
	 */
	public function purgeConnection()
	{
		$this->connection = null;

		return $this;
	}

	/**
	 * check if there's an active connection
	 * @return boolean [description]
	 */
	public function hasConnection()
	{
		return isset($this->connection) && $this->connection instanceof \PDO;
	}

	/**
	 * return current connection
	 * @return PDO
	 */
	public function getConnection()
	{
		return $this->connection;
	}
}
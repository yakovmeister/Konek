<?php

namespace Konek\Database;

use \PDO;

abstract class Connection implements ConnectionInterface
{
	protected $connection;

	protected $query;

	public function setConnection()
	{
		$this->connection = $this->connection();

		return $this;
	}

	public abstract function connection();

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
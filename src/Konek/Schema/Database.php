<?php

namespace Yakovmeister\Konek\Schema;

use Yakovmeister\Konek\Database\Connection;
use Yakovmeister\Konek\Configure\Config;
use Symfony\Component\Finder\Finder;

class Database
{
	protected static $connection;

	protected $schema;

	protected $db;

	public function __construct($databaseName)
	{
		static::$connection = new Connection(new Config(new Finder));

		static::$connection->getConnection()->exec("CREATE DATABASE {$databaseName}");
	}

	public function schema()
	{
		return $this->schema;
	}

	public static function drop($databaseName)
	{
		static::$connection->getConnection()->exec("DROP DATABASE IF EXISTS {$databaseName}");
	}

}
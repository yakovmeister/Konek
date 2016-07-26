<?php

namespace Konek\Database;

use Konek\Database\Connection;

class DB
{
	use Query;

	protected static $singleton;

	protected $connection;

	public function __construct($table = null, \Konek\Database\Connection $connection = null)
	{
		$this->table = $table;

		$this->connection = $connection ?? new \Konek\Database\Mysql\MysqlConnection;

		$this->connection->setConnection();
	}

	/**
	 * Fetch data from database
	 * 
	 * @access public
	 * @return \PDO
	 */
	public function get()
	{
		if(!$this->connection->hasConnection()) throw new \Exception("Uninitialized Connection");

		return $this->connection->getConnection()->query($this->compile())->fetchAll();
	}

	/**
	 * Execute INSERT/UPDATE/DELETE commands.
	 * 
	 * @access public
	 * @return \PDO
	 */
	public function execute()
	{
		if(!$this->connection->hasConnection()) throw new \Exception("Uninitialized Connection");	
		
		return $this->connection->getConnection()->exec($this->compile());	
	}

	/**
	 * Just in case you need to summon evil spirit, you can call our good friend singleton  
	 * no need to create a new instance of DB Class, damn it! just provide the table name, and 
	 * the connection instance. You're good to go.
	 * 
	 * @access public
	 * @param $table, Konek\Database\Connection $connection
	 * @return \Konek\Database\DB
	 */
	public static function instance($table = null, \Konek\Database\Connection $connection = null)
	{
		return static::$singleton ?? new self($table, $connection);
	}

}
<?php

namespace Yakovmeister\Konek\Database;

use Yakovmeister\Konek\Database\Connection;
use Yakovmeister\Konek\Database\Mysql\MysqlConnection;

class DB
{
	use Query;

	protected static $singleton;

	protected $connection;

	public function __construct($table = null, Connection $connection = null)
	{
		$this->table = $table;
		
		$this->connection = $connection ?? new MysqlConnection;
		
		$this->connection->setConnection();
	}

	/**
	 * Fetch data from database
	 * 
	 * @access public
	 * @return array
	 */
	public function get()
	{
		$this->checkConnection();

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
		$this->checkConnection();

		return $this->connection->getConnection()->exec($this->compile());	
	}

	/**
	 * Create new data and save it in database.
	 * 
	 * @access public
	 * @return \PDO
	 */
	public function create(array $data)
	{
		if(!$this->is_assoc_array($data)) throw new \Exception("DB::create method expects associative array, sequencial given");

		$keys = array_keys($data);
		$values = array_values($data);

		return $this->insert($values)->into($keys)->execute();
	}

	/**
	 * delete data from database by id
	 * 
	 * @access public
	 * @param $id
	 * @return \PDO
	 */
	public function rm($id)
	{
		return $this->delete($id)->execute();
	}

	/**
	 * Find specific data by id
	 * 
	 * @access public
	 * @param $id
	 * @return array
	 */
	public function find($id)
	{
		$this->checkConnection();
	
		return $this->connection->getConnection()->query($this->where("id","=",$id)->limit(1)->compile())->fetchAll()[0];
	}

	public function checkConnection()
	{
		if(!$this->connection->hasConnection()) throw new \Exception("Uninitialized Connection");	

		return ;	
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
	public static function instance($table = null, Connection $connection = null)
	{
		return static::$singleton ?? new self($table, $connection);
	}

}
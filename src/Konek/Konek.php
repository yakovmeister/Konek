<?php namespace Yakovmeister\Konek;

use \PDO;
use \PDOException;

/**
 *	@author Jacob Baring (Yakovmeister)
 *			http://www.facebook.com/rwx777kid.ph
 *	@version 1.0.0
 */

class Konek extends KonekException
{
	protected $_db;

	protected $_configPath;

	protected $connectionProperties = [];

	protected $_table;

	protected $_query;

	protected $_result;

	public function __construct() 
	{
		if(!$this->hasConnectionProperties() || !$this->isActive())
		{
			$this->getConnectionProperties();
			$this->open();		
		}
	}
 
	public function getConnectionProperties() 
	{

		try {

			$this->connectionProperties = @require($this->getConfig());

			if(!$this->hasConnectionProperties()) throw new KonekException("Cannot fetch empty connection properties", 1);

			return $this->connectionProperties;	
		
		} catch (KonekException $ex) {
			
		}
	
	}

	public function hasConnectionProperties()
	{
		if(empty($this->connectionProperties)) return false;

		return true;
	}

	public function getConfig()
	{
		if($this->hasConfig()) return $this->_configPath;

		//set default config
		$this->_configPath = dirname(dirname(dirname(__FILE__))).'/config/database.php';

		return $this->_configPath;
	}

	public function hasConfig()
	{
		return isset($this->_configPath) && file_exists($this->_configPath)	? true : false;
	}

	public function setConfig($path)
	{
		$this->_configPath = $path;

		return $this;
	}

	public function isActive()
	{
		return ($this->_db instanceof PDO);
	}

	public function open()
	{
		try
		{
			if(!$this->hasConnectionProperties()) throw new KonekException("Cannot establish empty connection.", 0);	
			
			try {	

					$this->_db = ($this->isActive()) ? $this->_db : new PDO($this->getConnectionDSN(), $this->getConnectionUsername(), $this->getConnectionPassword(), $this->getPDOAttributes());							

			} catch(PDOException $ex) {
		
				throw new KonekException($ex->getMessage(), 1);
		
			}
		} catch(KonekException $ex) {
			// Log Later
			// Notify::error($ex->__toArray());
		}

		return $this->isActive(); 
	}
	
	private function getPDOAttributes()
	{
		return [
			PDO::ATTR_DEFAULT_FETCH_MODE 	=> PDO::FETCH_ASSOC,
		//	PDO::ATTR_PERSISTENT			=> true
		];
	}

	private function getConnectionDSN()
	{
		if($this->hasConnectionProperties())
		{
			return "{$this->connectionProperties['driver']}:dbname={$this->connectionProperties['database']};host={$this->connectionProperties['host']}";
		}
	}

	private function getConnectionUsername()
	{
		if($this->hasConnectionProperties())
		{
			return $this->connectionProperties['username'];
		}
	}

	private function getConnectionPassword()
	{
		if($this->hasConnectionProperties())
		{
			return $this->connectionProperties['password'];
		}
	}

	public function setConnectionProperties(array $connectionProperties)
	{
		$this->close();

		$this->connectionProperties = $connectionProperties;

		$this->open();
	}

	public function close() 
	{
		$this->_db = null;

		return $this->isActive();
	}

	public function table($table = null)
	{
		try {

			if(!$this->isActive()) throw new KonekException("The Connection is not Active", 4);

			$this->_table = $table;

			return $this;	
		
		} catch (KonekException $ex) {

		}
	}

	public function where($find, $operation, $where)
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			if(!empty($this->_query))
			{
				$this->_query .= ($this->hasKeyword($this->_query, "WHERE") ? " AND {$find} {$operation} '{$where}'" : " WHERE {$find} {$operation} '{$where}'");

				return $this;
			}
		
			$this->_query = "SELECT * FROM {$this->_table} WHERE {$find} {$operation} '{$where}'";

			return $this;
		
		} catch (KonekException $ex) {

		}
	}

	public function hasKeyword($haystack, $keyword)
	{
		if(!is_array($haystack)) $haystack = explode(" ", $haystack);

		foreach ($haystack as $needle) 
		{
			if($needle == $keyword)	return true;
		}	
			
		return false;
	}

	public function orWhere($find, $operation, $where)
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			if(!empty($this->_query))
			{
				$this->_query .= ($this->hasKeyword($this->_query, "WHERE") ? " OR {$find} {$operation} '{$where}'" : " WHERE {$find} {$operation} '{$where}'");
		
				return $this;
			}

			return $this->where($find, $operation, $where);
	
		} catch (KonekException $ex) {

		}
	}

	public function find($id)
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			$this->_query = "SELECT * FROM {$this->_table} WHERE id = {$id}";

			return $this->_db->query($this->_query)->fetchAll()[0];

		} catch(PDOException $ex) {
		
			throw new KonekException($ex->getMessage(), $ex->getCode());
		
		} catch (KonekException $ex) {

		}
	}

	public function select($row) 
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			$this->_query = (is_array($row) ? "SELECT ".implode(", ", $row)." FROM {$this->_table}" : "SELECT {$row} FROM {$this->_table}");

			return $this;

		} catch (KonekException $ex) {

		}
	}

	public function all()
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			$this->_query = "SELECT * FROM {$this->_table}";

			return $this->_db->query($this->_query)->fetchAll();

		} catch(PDOException $ex) {
		
			throw new KonekException($ex->getMessage(), $ex->getCode());
		
		} catch (KonekException $ex) {

		}
	}

	public function get($place = 0)
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			$this->_result = $this->_db->query($this->_query);

			return @( ($place >= 1) ? $this->_result->fetchAll()[($place - 1)] : $this->_result->fetchAll());

		} catch(PDOException $ex) {
		
			throw new KonekException($ex->getMessage(), $ex->getCode());
		
		} catch (KonekException $ex) {

		}
	}

	public function execute($query) 
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			return $this->_db->exec($query);

		} catch(PDOException $ex) {
		
			throw new Exception($ex->getMessage(), $ex->getCode());
		
		} catch (KonekException $ex) {

		}
	}

	public function delete($id)
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			$this->_query = "DELETE FROM {$this->_table} WHERE id = {$id}";

			return $this->_db->exec($this->_query);

		} catch(PDOException $ex) {
		
			throw new KonekException($ex->getMessage(), $ex->getCode());
		
		} catch (KonekException $ex) {

		}
	}

	public function insert(array $items) 
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			$list = $this->commaSeparate($items);

			return $this->_db->exec("INSERT INTO {$this->_table} ({$list['key']}) VALUES ({$list['values']})");

		} catch(PDOException $ex) {
		
			throw new KonekException($ex->getMessage(), $ex->getCode());
		
		} catch (KonekException $ex) {

		}
	}

	public function update($id, array $items) 
	{
		try {

			if(!$this->isActive()) throw new KonekException("The connection is inactive", 4);

			$list = $this->assignSeparate($items);

			return $this->_db->exec("UPDATE {$this->_table} SET {$list} WHERE id={$id}");

		} catch(PDOException $ex) {
		
			throw new KonekException($ex->getMessage(), $ex->getCode());
		
		} catch (KonekException $ex) {

		}
	}

	public function commaSeparate(array $values)
	{
		$commaSeparated['values'] 	= '';
		$commaSeparated['key'] 		= '';

		foreach ($values as $key => $value) 
		{
			$commaSeparated['values'] 	.= "'{$value}',";
			$commaSeparated['key']  	.= "{$key},";
		}

		$commaSeparated['key']  	= trim($commaSeparated['key'], ",");
		$commaSeparated['values'] 	= trim($commaSeparated['values'], ",");

		return $commaSeparated;
	}

	public function assignSeparate(array $values)
	{
		$assignSeparated 	= '';

		foreach ($values as $key => $value) 
		{
			$assignSeparated .= "{$key}='{$value}', ";
		}

		return trim($assignSeparated, ", ");
	}

	public function isMultiDimension(array $array)
	{
		foreach ($array as $value) 
		{
			if(is_array($value)) return true;
		}

		return false;
	}
}
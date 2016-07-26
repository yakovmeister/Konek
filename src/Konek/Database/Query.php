<?php

namespace Konek\Database;

trait Query
{
	protected $distinct = false;

	protected $count = false;

	protected $raw = false;

	protected $oldTable;

	protected $table;
	
	protected $columns;

	protected $groupBy;

	protected $offset;

	protected $limit;

	protected $orders;

	protected $whereExpression;

	protected $expression;

	protected $pdo;

	protected $command;

	protected $hint;

	protected $query;

	protected $operators = [
		"<>", "!=", ">", "<", ">=", "=",
		"<=", "!<", "!>", "LIKE", "NOT"
	];

	public function __construct($table = null)
	{
		$this->table = $table;
	}

	/**
	 * Set distinct to true
	 *
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function distinct()
	{
		$this->distinct = true;

		return $this;
	}

	/**
	 * Set properties to its default value
	 *
	 * @access public
	 */
	public function flush()
	{

		$this->table = $this->oldTable ?? $this->table;

		$this->groupBy = null;

		$this->distinct = false;

		$this->count = false;

		$this->raw = false;

		$this->columns = null;
		
		$this->offset = null;
		
		$this->limit = null;
		
		$this->orders = null;
		
		$this->whereExpression = null;

		$this->expression = null;
		
		$this->command = null;
		
		$this->query = null;
	}

	/**
	 * Order of the phoenix
	 *
	 * @param $column, $direction
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function orderBy($column, $direction = "asc")
	{
		$direction = strtolower($direction) == "asc" ? "ASC" : "DESC";

		$this->orders = compact("column", "direction");

		return $this;
	}

	/**
	 * Set initial command as SELECT and set columns 
	 *
	 * @param $columns
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function select($columns = ['*'])
	{
		$this->command = strtoupper(__FUNCTION__);
		
		$this->setColumns($columns);

		return $this;
	}

	/**
	 * Group data according to column name
	 *
	 * @param $column
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function groupBy($column)
	{
		$this->groupBy = func_num_args() > 1 ? func_get_args() : $column;

		return $this;
	}

	/**
	 * Set value to columns property
	 *
	 * @param $columns
	 * @access public
	 * @return \Konek\Database\Query
	 */	
	public function setColumns($columns = ['*'])
	{
		$this->columns = is_array($columns) ? $columns : func_get_args();

		return $this;
	}

	/**
	 * Set INSERT as initial command and set data 
	 *
	 * @param $values
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function insert($values)
	{
		$this->command = strtoupper(__FUNCTION__);

		$values = func_num_args() > 1 ? func_get_args() : $values;

		$this->expression = $this->chainWrap($values);

		return $this;
	}

	/**
	 * Set columns for INSERT
	 *
	 * @param $columns
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function into($columns = ['*'])
	{
		$columns = func_num_args() > 1 ? func_get_args() : $columns;

		$this->setColumns($columns);

		return $this;
	}

	/**
	 * Set UPDATE as initial command, set expression, set where
	 *
	 * @param $id, $value
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function update($id, $value)
	{
		$this->command = strtoupper(__FUNCTION__);

		if(!is_array($value)) throw new \Exception("Update method expecting one argument as array ".gettype($value)." given");
		if(!$this->is_assoc_array($value)) throw new \Exception("Update method expecting Associative Array, Sequencial given");

		$this->updateWhere("id","=", $id, $value);

	//	$this->where("id", $id)->limit(1);

		return $this;

	}

	/**
	 * Set UPDATE as initial command, set expression, set where
	 *
	 * @param $id, $value
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function updateWhere($column, $operator, $value, $values, $limit = 1)
	{
		$this->command = strtoupper(substr(__FUNCTION__, 0, 6));

		if(!is_array($values)) throw new \Exception("Update method expecting one argument as array ".gettype($value)." given");
		if(!$this->is_assoc_array($values)) throw new \Exception("Update method expecting Associative Array, Sequencial given");

		foreach ($values as $key => $val) {
			$this->expression[] = "{$key} = \"{$value}\"";
		}

		$this->expression = implode(", ", $this->expression);

		$this->where($column, $operator, $value)->limit($limit);

		return $this;
	}

	/**
	 * Check if array is associative
	 *
	 * @param $array
	 * @access public
	 * @return bool
	 */
	public function is_assoc_array($array)
	{
		return array_keys($array) !== range(0, count($array) - 1);
	}

	/**
	 * Compile properties to query string
	 *
	 * @access public
	 * @return string
	 */
	public function compile()
	{
		if(!$this->table) throw new \Exception("Cannot run query without table");

		$this->query = $this->command ?? "SELECT";

		switch($this->query)
		{
			case "SELECT":

				$this->query .= $this->distinct ? " DISTINCT " : " ";

				$this->query .= $this->count == true ? "COUNT({$this->chain()}) " : $this->chain($this->columns) ?? $this->chain();

				$this->query .= " FROM {$this->table}";

				$this->query .= $this->whereExpression;

				if(!$this->raw)
				{	
					if($this->groupBy) $this->query .= " GROUP BY {$this->chain($this->groupBy)}";

					if($this->orders) $this->query .= " ORDER BY {$this->orders["column"]} {$this->orders["direction"]}";

					if($this->limit) $this->query .= " LIMIT {$this->limit}";

					if($this->offset) $this->query .= " OFFSET {$this->offset}";	
				}

			break;
			case "UPDATE":

				$this->query .= " {$this->table} SET ";

				$this->query .= $this->expression;

				$this->query .= $this->whereExpression;

				if($this->orders) $this->query .= " ORDER BY {$this->orders["column"]} {$this->orders["direction"]}";

				if($this->limit) $this->query .= " LIMIT {$this->limit}";

			break;
			case "INSERT":
			
				$this->query .= " INTO {$this->table}";

				$this->query .= $this->columns ? " ({$this->chain($this->columns)})" ?? $this->chain() : " ";
				
				$this->query .= " VALUES ({$this->expression})";

			break;
			case "DELETE":
				
				$this->query .= " FROM {$this->table}";

				$this->query .= $this->whereExpression;				
				
				if($this->limit) $this->query .= " LIMIT {$this->limit}";

			break;
		}
		
		$cache = $this->query;

		$this->flush();

		return $cache;
	}

	/**
	 * Set initial command as DELETE find item by id
	 *
	 * @param $id
	 * @access public
	 * @return \Konek\Database\Query::compile()
	 */
	public function delete($id)
	{
		$this->command = strtoupper(__FUNCTION__);
	
		$this->where("id",$id)->limit(1);

		return $this;
	}

	/**
	 * Delete based on where clause
	 *
	 * @param $column, $operator, $value, $limit
	 * @access public
	 * @return \Konek\Database\Query::compile()
	 */
	public function deleteWhere($column, $operator = null, $value = null, $limit = 1)
	{
		$this->command = strtoupper(substr(__FUNCTION__, 0, 6));

		if($limit > 0) $this->where($column, $operator, $value)->limit($limit); 
		else $this->where($column, $operator, $value);

		return $this;
	}

	/**
	 * Set how many data should be returned
	 *
	 * @param $count
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function limit($count)
	{
		$this->limit = $count;

		return $this;
	}

	/**
	 * Set how many data should be skipped
	 *
	 * @param $count
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function skip($count)
	{
		$this->offset = $count;

		return $this;
	}

	/**
	 * Count how many rows are affected
	 *
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function count()
	{
		$this->count = true;

		return $this;
	}

	/**
	 * Convert array to string as listed items
	 *
	 * @param $columns
	 * @access public
	 * @return string
	 */
	public function chain($columns = ['*'])
	{
		if(!is_array($columns)) return $columns;

		return implode(", ", $columns);
	}

	/**
	 * Convert array to string as listed items and wrap them with quote
	 *
	 * @param $values
	 * @access public
	 * @return string
	 */
	public function chainWrap($values)
	{
		$values = is_array($values) ? $values : func_get_args();

		return implode(", ", $this->wrapArray($values));
	}

	/**
	 * Wrap string with quote
	 *
	 * @param $value
	 * @access public
	 * @return string
	 */
	public function wrap($value)
	{
        if ($value === '*') {
            return $value;
        }

        return '"'.str_replace('"', '""', $value).'"';
	}

	/**
	 * Query::wrap for array
	 *
	 * @param $array
	 * @access public
	 * @return string
	 */
	public function wrapArray($array)
	{
		if(!is_array($array)) return $this->wrap($array);
		
		$cache = [];

		foreach ($array as $value) {
			$cache[] = $this->wrap($value);
		}

		return $cache;
	}

	/**
	 * Set table
	 *
	 * @param $table
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function from($table)
	{
		if($table instanceof \Closure) {
			$this->oldTable = $this->table; 
			$this->table = "({$table()->compile()})";
		}
		else $this->table($table);

		return $this;
	}

	/**
	 * Set table "no closure support"
	 *
	 * @param $table
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function table($table)
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Check if operator being used is invalid
	 *
	 * @param $operator
	 * @access public
	 * @return bool
	 */
	public function invalidOperator($operator)
	{
		$operator = explode(' ', $operator);

		if(count($operator) <= 1) return !in_array(strtoupper($operator[0]), $this->operators);
		elseif(is_array($operator) && strtolower($operator[0]) != "not") return true;
		elseif(count($operator) > 2) return true;

		if(is_array($operator) && strtolower($operator[1]) != "like") return true;

		return false;
	}

	/**
	 * Set where expression
	 *
	 * @param $column, $operator, $value, $boolean
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function where($column, $operator = null, $value = null, $boolean = 'and')
	{
		$boolean = strtoupper($boolean);

		$whereClause = strtoupper(__FUNCTION__);

		if(func_num_args() == 2)
		{
			list($value, $operator) = [$operator, '='];
		} 
		else if($this->invalidOperator($operator)) 
		{
			throw new \Exception("Invalid Operator");
		}

		if($this->whereExpression) $this->whereExpression .= " {$boolean} {$whereClause} {$column} {$operator} {$this->wrapArray($value)}";
		else $this->whereExpression = " {$whereClause} {$column} {$operator} {$this->wrapArray($value)}";

		return $this;
	}

	/**
	 * Enables you to set raw expression for where clause
	 *
	 * @param $columns
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function whereRaw($expression)
	{
		$this->raw = true;

		$this->whereExpression = " WHERE {$expression}";

		return $this;
	}

	/**
	 * Set `where and` expression
	 *
	 * @param $column, $operator, $value
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function whereAnd($column, $operator = null, $value = null)
	{
		return $this->where($column, $operator, $value);
	}

	/**
	 * Set `where or` expression
	 *
	 * @param $column, $operator, $value
	 * @access public
	 * @return \Konek\Database\Query
	 */
	public function whereOr($column, $operator = null, $value = null)
	{
		return $this->where($column, $operator, $value, "or");
	}

}
<?php

namespace Yakovmeister\Konek\Schema;

class Schema
{

	/**
	 * columns you want to add in the schema
	 * @var array
	 */
	protected $columns = [];

	/**
	 * columns with primary keys
	 * @var array
	 */
	protected $primaryKeys = [];

	/**
	 * columns with autoIncrements
	 * @var array
	 */
	protected $autoIncrements = [];

	/**
	 * columns with nullables
	 * @var array
	 */
	protected $nullables = [];

	/**
	 * current column
	 * @var [type]
	 */
	protected $currentColumn;

	public function add($column, $type)
	{
		$this->currentColumn = $column;

		array_push($this->columns, [
				'column' => $column,
				'type' => $type
			]);

		return $this;
	}

	public function nullable($isNullable = true)
	{
		$this->nullables[$this->currentColumn] = $isNullable;

		return $this;
	}
}


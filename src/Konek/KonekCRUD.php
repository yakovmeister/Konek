<?php namespace Yakovmeister\Konek;

/**
 *	@author Jacob Baring (Yakovmeister)
 *			http://www.facebook.com/rwx777kid.ph
 *	@version 1.0.0
 */

use Yakovmeister\Konek\Konek;

class KonekCRUD implements KonekCRUDInterface
{

	protected $_table;

	protected $konek;

	public function __construct(Konek $app)
	{
		$this->konek = $app;
	}	

	public function table($tableName)
	{
		$this->_table = $tableName;

		return $this;
	}

	public function create(array $items)
	{
		if($this->konek->isMultiDimension($items))
		{
			foreach ($items as $value) 
			{
				$this->konek->table($this->_table)->insert($value);
			}
		}
		else 
		{
			return $this->konek->table($this->_table)->insert($items);
		}
	}

	public function update($id, array $items)
	{
		if($this->konek->isMultiDimension($items))
		{
			foreach ($items as $value) 
			{
				$this->konek->table($this->_table)->update($id, $value);
			}
		}
		else 
		{
			return $this->konek->table($this->_table)->update($id, $items);
		}
	}
	
	public function find($id)
	{
		return $this->konek->table($this->_table)->find($id);
	}

	public function delete($id)
	{
		return $this->konek->table($this->_table)->delete($id);
	}
}
<?php namespace Yakovmeister\Konek;

/**
 *	@author Jacob Baring (Yakovmeister)
 *			http://www.facebook.com/rwx777kid.ph
 *	@version 1.0.0
 */

abstract class KonekModel extends KonekCRUD
{
	protected $__table;

	private $__crud;

	public function __construct(Konek $activeConnection, $table = null)
	{
		if(is_null($table))
		{
			$this->__table = isset($this->table) ? strtolower($this->table) : strtolower(get_called_class());
		}
		else
		{
			$this->__table = $table;
		}

		$this->_table = $this->__table;
		
		$this->crud 	= parent::__construct($activeConnection);
	}

}
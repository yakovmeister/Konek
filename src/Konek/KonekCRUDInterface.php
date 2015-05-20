<?php namespace Yakovmeister\Konek;

/**
 *	@author Jacob Baring (Yakovmeister)
 *			http://www.facebook.com/rwx777kid.ph
 *	@version 1.0.0
 */

interface KonekCRUDInterface 
{
	public function create(array $items);
	public function update($id, array $items);
	public function find($id);
	public function delete($id);
}
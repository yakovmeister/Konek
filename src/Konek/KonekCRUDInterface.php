<?php namespace Yakovmeister\Konek;

interface KonekCRUDInterface 
{
	public static function getInstance();
	public function create(array $items);
	public function update($id, array $items);
	public function find($id);
	public function delete($id);
}
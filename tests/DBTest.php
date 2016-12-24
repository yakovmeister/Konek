<?php

use PHPUnit\Framework\TestCase;
use Yakovmeister\Konek\Database\DB;

class DBTest extends TestCase
{

	protected $db;

	public function setUp()
	{
		$this->db = new DB("users");
	}
	
	public function testReturnedIsObject()
	{
		$this->assertTrue(is_object($this->db->all()));
	}
}
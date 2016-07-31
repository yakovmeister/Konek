<?php

namespace Yakovmeister\Konek\Database\Mysql;

use Yakovmeister\Konek\Database\Connection;

class MysqlConnection extends Connection
{

	public function connection()
	{
		return new \PDO("mysql:dbname=db_test;host=localhost","root","");
	}

}
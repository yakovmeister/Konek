<?php

namespace Yakovmeister\Konek\Database\Sqlite;

use Yakovmeister\Konek\Database\Connection;

class SqliteConnection extends Connection
{

	public function connection()
	{
		return new \PDO("sqlite:././././db/db.sqlite");
	}

}
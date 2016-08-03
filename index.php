<?php

require('vendor/autoload.php');

use Yakovmeister\Konek\Database\DB;
use Yakovmeister\Konek\Database\Sqlite\SqliteConnection;
// run sample


// SELECT * FROM users
DB::instance("users", new SqliteConnection)->get();
// SELECT * FROM users where username like gwapo
DB::instance("users", new SqliteConnection)->where("username","LIKE","gwapo")->get();
// SELECT * FROM users where id = 1
DB::instance("users", new SqliteConnection)->where("id", 1);
// or
DB::instance("users", new SqliteConnection)->where("id", "=" ,1);
/*
//creating new data : INSERT INTO users id, username, password VALUES (1, supergwapo, gwapopass)
DB::instance("users", new SqliteConnection)->create([
		"username" => "supergwapo",
		"password" => "gwapopass"
	]);
// deleting data: DELETE FROM users WHERE id = 1
DB::instance("users", new SqliteConnection)->rm(1);
*/
//you can also try
$database = new DB("users"); //automatically sets to sql if second argument is not provided
// SELECT * FROM users WHERE username = gwapo LIMIT 1
$database->where("username","=","gwapo")->limit(1)->get();

var_dump(DB::instance("users", new SqliteConnection)->all());

class Sample 
{
	public function add($key, $val)
	{
		$this[$key] = $val;

		return $this;
	}
}

$x = new Sample;
$x->add("gwapo","kaayo");

echo $x['gwapo'];
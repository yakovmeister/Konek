<?php

require('vendor/autoload.php');

use Yakovmeister\Konek\Database\DB;
use Yakovmeister\Konek\Database\Sqlite\SqliteConnection;
// run sample

// our way of telling
// SELECT * from users
$data = DB::instance("users", new SqliteConnection)->get();

$data = DB::instance("users", new SqliteConnection)->find(1);

var_dump($data["password"]);
<?php 

/*
Setup Konek

locate config/database.php change the value according to your database server. save.

using Konek Connector

The Basics

// include vendor/autoload.php at the start of your code

//create an instance of Konek
$connection = new Konek;

// define table name
$connection->table('users');

// SELECT * FROM users;
$connection->all();

// SELECT * FROM users where username = 'admin'
$connection->where('username','=','admin');

// Multiple WHERE
// SELECT * FROM users where username = 'admin' AND password = 'anonymous'
$connection->where('username','=','admin')->where('password', '=', 'anonymous');

//fetching results.
$connection->where('username','=','admin')->where('password', '=', 'anonymous')->get();

//fetching results according to their counting
$connection->where('username','=','admin')->where('password', '=', 'anonymous')->get(1); // get the first result only
$connection->where('username','=','admin')->where('password', '=', 'anonymous')->get(3); // get the third result only

using KonekCRUD

$connection = new Konek; // create Konek instance
$crud 		= new KonekCRUD($connection); // pass connection to our crud

$crud->table('users')->create([
	'username'	=> 'adminv2',
	'password'	=> 'passwordv2',
	'email'		=> 'my@ownemail.com'
]);

Advance


Changing database connection on fly.

// assume that we already opened a connection
// add this line next to $connection = new Konek;
$connection->setConnectionProperties([
	'driver'	=> 'mysql',
	'database' 	=> 'YourDatabaseName',
	'host'		=> 'YourHost',
	'username'	=> 'YourUsername',
	'password'	=> 'YourPassword'
]);
// no need to call open.

*/ ?>



<?php

require('vendor/autoload.php');

use Yakovmeister\Konek\Konek;
use Yakovmeister\Konek\KonekCRUD;

// initialize new instance of Connector 
$connection = new Konek;
$crud 		= new KonekCRUD($connection);
//$model 		= new Users;

echo "<h2>Methods Testing:</h2><br/><br/><br/>";

echo "<h3>Konek Class</h3><br />";
echo "<p style='color:#f00;'>::__construct() => ";
var_dump($connection);
echo "</p>";

echo "<p style='color:#f00;'>::getConnectionProperties() => ";
var_dump($connection->getConnectionProperties());
echo "</p>";


echo "<p style='color:#f00;'>::hasConnectionProperties() => ";
var_dump($connection->hasConnectionProperties());
echo "</p>";

echo "<p style='color:#f00;'>::getConfig() => ";
var_dump($connection->getConfig());
echo "</p>";

echo "<p style='color:#f00;'>::hasConfig() => ";
var_dump($connection->hasConfig());
echo "</p>";


echo "<p style='color:#f00;'>KonekCRUD::find(\$id) => ";
var_dump($crud->table('users')->find(36));
var_dump($crud->find(1));
echo "</p>";



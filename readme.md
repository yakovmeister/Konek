
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
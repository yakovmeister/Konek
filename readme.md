
Connector Class can be used not only for loging in.

you can also establish a connection via setConnectionProperties() instead of relying on the default.

	setConnectionProperties(array $connectionProperties)
ex.

	$connection = new Connector; // <-- initialized session_start(), getConnectionProperties() and opens new PDO class
	$connection->setConnectionProperties([
							'driver'	=> 'mysql',
							'database' 	=> 'login',
							'host'		=> 'localhost',
							'username'	=> 'root',
							'password'	=> ''
	]);				// closes old connection and establish a new one based on your connectionProperties


selecting table, if you're a bit familiar with Model (MVC), this is a little bit similar.

table($table = null) // if the value is null, automatically the users table will be used.

// example of our query
$connection->table("fish")->where("taste","like","tuna");
// the above code if executed will be:
// 			SELECT * from fish WHERE taste like tuna;


use query() for SELECT , and use execute() for INSERT, UPDATE, DELETE. getch?

naahh... enough instructions, read the goddamn Connector.php

NOTE: dont forget to initialize an instance of Connector.php on top of your every page. remember, ON TOP.

contact me if there's a goddamn issue. okay?

email: electro7bug@gmail.com
facebook: /rwx777kid.ph
<?php

return [
	'default' => 'mysql',
	'connections' 	=> [

		'mysql' => [
			'host'		=> 'localhost',
			'username' 	=> 'root',
			'password' 	=> '',
			'database'	=> 'db_test'
		],

		'sqlite' => [
			'database' => 'db/db.sqlite'
		]
	]
];
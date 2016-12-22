<?php

return [
	'default' => 'sqlite',
	'connections' 	=> [

		'mysql' => [
			'hostname'	=> 'localhost',
			'username' 	=> 'root',
			'password' 	=> '',
			'database'	=> 'db_test'
		],

		'sqlite' => [
			'database' => 'db/db.sqlite'
		]
	]
];
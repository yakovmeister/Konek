<?php

return [
	'default' 		=> 'mysql',
	'connections' 	=> [

		'mysql' => [
			'hostname'	=> 'localhost',
			'username' 	=> 'root',
			'password' 	=> '',
			'database'	=> 'db_test'
		],

		'sqlite' => [
			'database' => 'db.sqlite'
		]
	]
];
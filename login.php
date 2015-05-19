<?php

// require Connector.php 
require('vendor/autoload.php');

// initialize new instance of Connector
// it also triggers session_start() and PDO 
$connection = new Connector;


if($connection->auth($_GET['username'], $_GET['password']))
{
	$connection->login($_GET['username'], $_GET['password']);
	header("Location: panel.php");
}
else 
{
	echo "<h2>Wrong Username or Password</h2>";
}
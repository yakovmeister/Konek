<?php

// require Connector.php 
require('class/Connector.php');

// initialize new instance of Connector
// it also triggers session_start() and PDO 
$connection = new Connector;

// redirect to our panel if already registered;
if($connection->logged()) header("Location: panel.php");


$isRegistered = $connection->register($_GET['username'], $_GET['password'], $_GET['email']);

if($isRegistered && $connection->auth($_GET['username'], $_GET['password']))
{
	header("Location: login.php");
}
else
{
	echo "<h2>Unable to Register</h2>";
}
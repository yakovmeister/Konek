<?php

// require Connector.php 
require('class/Connector.php');

// initialize new instance of Connector
// it also triggers session_start() and PDO 
$connection = new Connector;

// redirect to our panel if already registered;
if($connection->logged()) header("Location: panel.php");

?>

<form id="x" method="GET" action="reg.php">
	<input type="text" id="username" name="username" placeholder="username">
	<input type="text" id="email" name="email" placeholder="email">
	<input type="password" id="password" name="password" placeholder="password">
	<input type="submit" value="Login">
</form>
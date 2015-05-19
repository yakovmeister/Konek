<?php
//our admin panel
// require Connector.php 
require('class/Connector.php');

// initialize new instance of Connector
// it also triggers session_start() and PDO 
$connection = new Connector;
?>


<h1>Welcome to admin panel!</h1>

<a href="logout.php">logout</a>
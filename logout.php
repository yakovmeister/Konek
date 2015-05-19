<?php

// require Connector.php 
require('class/Connector.php');

// initialize new instance of Connector
// it also triggers session_start() and PDO 
$connection = new Connector;

$connection->logout();
header("Location: index.php");
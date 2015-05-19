<?php

require('vendor/autoload.php');

use Yakovmeister\Konek\Konek;
use Yakovmeister\Konek\KonekCRUD;

// initialize new instance of Connector 
$connection = Konek::getInstance();
$crud 		= KonekCRUD::getInstance();



//var_dump($connection->table("usersd")->all());


//var_dump($connection->getConnectionProperties());

//$db = new PDO("mysql:dbname=sampleDatabase;host=localhost","root","");

//$users2 = $db->query("SELECT * FROM user WHERE username = 'admin'")->fetchAll();



//var_dump(new Fucks(new Connector));
var_dump($connection->isActive());
echo "<h2>Methods Testing:</h2><br/><br/><br/>";

echo "<h3>Konek Class</h3><br />";
echo "<p style='color:#f00;'>::getInstance() => ";
var_dump($connection);
echo "</p>";

echo "<p style='color:#f00;'>::getConnectionProperties() => ";
var_dump($connection->getConnectionProperties());
echo "</p>";


echo "<p style='color:#f00;'>::hasConnectionProperties() => ";
var_dump($connection->hasConnectionProperties());
echo "</p>";

echo "<p style='color:#f00;'>::getConfig() => ";
var_dump($connection->getConfig());
echo "</p>";

echo "<p style='color:#f00;'>::hasConfig() => ";
var_dump($connection->hasConfig());
echo "</p>";

echo "<p style='color:#f00;'>::getConnectionString() => ";
var_dump($connection->getConnectionDSN());
echo "</p>";

echo "<p style='color:#f00;'>::getConnectionUsername() => ";
var_dump($connection->getConnectionUsername());
echo "</p>";

echo "<p style='color:#f00;'>::getConnectionPassword() => ";
var_dump($connection->getConnectionPassword());
echo "</p>";


var_dump($connection->table('users')->where("username", "=", "aw")->get());
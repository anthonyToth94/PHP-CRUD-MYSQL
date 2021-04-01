<?php

function nav(){
	echo '
		<li><a href="index.php?page=home">Kezdőlap</a></li>
		<li><a href="index.php?page=regisztracio">Regisztráció</a></li>
	';
}

function dbConnection(){

$dsn = "mysql:host=localhost;dbname=phpproject;charset=utf8mb4";
$username = "root";
$password = "";

$db = new PDO($dsn, $username, $password);

return $db;



}

?>
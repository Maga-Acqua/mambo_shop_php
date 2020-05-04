<?php
	$host = "localhost";
	$user = "root";
	$pass = "1234";
	$db = "mambo_db";
	
	$conexion = new PDO("mysql:host=" . $host . ";dbname=" . $db, $user, $pass);
	$conexion->exec("SET CHARACTER SET utf8");
?>
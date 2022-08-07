<?php

$container->set('db_connect', function(){
	$DB_HOST = $_ENV['DB_HOST'];
	$DB_USER = $_ENV['DB_USER'];
	$DB_PASSWORD = $_ENV['DB_PASSWORD'];
	$DB_NAME = $_ENV['DB_NAME'];

	$opt = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
	];

	$dns = "mysql:host=". $DB_HOST .";dbname=". $DB_NAME;
	return new PDO($dns, $DB_USER, $DB_PASSWORD, $opt);
});
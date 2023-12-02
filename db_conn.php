<?php
date_default_timezone_set('Asia/Manila');

$host = "localhost:3306";
$dbname = "fatimadb";
$username = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8;";

try {
	$pdo = new PDO($dsn, $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo $e->getMessage();
}

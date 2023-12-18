<?php
$dsn = "mysql:host=127.0.0.1;dbname=muskelabcd_muskelDB";
$user = "muskelabcd_physioUnited";
$pass = "muskelabcd_physioUnited";
$options = array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_PERSISTENT => true,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
try {
	//Instanz von PDO (Datenbankverbindung aufbauen)
	$db = new PDO($dsn, $user, $pass, $options);
	//UTF8 für Querys
	$db->query("SET NAMES utf8");
} catch (PDOException $err) {
	echo "Ein Fehler ist aufgetreten!";
	echo $err->getMessage();
}

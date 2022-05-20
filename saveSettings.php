<?php
	session_start(); 
	include "config.php";
	
	$conn = new mysqli($host, $user, $password, $dbname);
	if ($conn->errno)
		die("Problemi di connessione" . $conn->error);
	mysqli_set_charset($conn, "utf8");
	
	//TODO
	
	header("Location: userSettings.php");
?>
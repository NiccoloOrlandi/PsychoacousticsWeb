<?php
session_start();
include "config.php";

$conn = new mysqli($host, $user, $password, $dbname);
		if ($conn->errno)
			die("Problemi di connessione" . $conn->error);
		mysqli_set_charset($conn, "utf8");
$sql = "SELECT email FROM account WHERE Username ='".$_SESSION['usr']."'";             //manca email nel database quindi ancora non funziona
$result=$conn->query($sql);
$row = $result->fetch_assoc();
mail($row['email'],'Password changing','you have correctly changed the password');
?>
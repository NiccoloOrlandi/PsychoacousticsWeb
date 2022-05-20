<?php
	session_start(); 
	include "config.php";
	
	$conn = new mysqli($host, $user, $password, $dbname);
	if ($conn->errno)
		die("Problemi di connessione" . $conn->error);
	mysqli_set_charset($conn, "utf8");
	
	$sql = "SELECT referral FROM account WHERE username='".$_SESSION['usr']."'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$ref = $row['referral'];
	
	$newRef = base64_encode($_SESSION['usr'].rand(-9999, 9999));
	while($newRef == $ref)
		$newRef = base64_encode($_SESSION['usr'].rand(-9999, 9999));
	
	$sql = "UPDATE account SET referral='$newRef' WHERE username='".$_SESSION['usr']."'";
	$conn->query($sql);
	
	header("Location: userSettings.php");
?>
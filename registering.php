<?php
	session_start();
	$conn = new mysqli("localhost", "test", "", "psychoacoustics_db");
	if ($conn->errno)
	    die("Problemi di connessione" . $conn->error);
	
    $usr = $_POST['usr'];
    
    $sql = "SELECT * FROM account WHERE username='$usr'";
    $result=$conn->query($sql);
    if($result->num_rows>0)  
	//se non esiste eseguo la registrazione
    else{
		$sql = "INSERT INTO account VALUES ('$usr', SHA2('$psw', 256), '$id')";
    	$conn->query($sql);
    	$_SESSION['usr'] = $usr;
    	
    	$conn->close();
    	header('Location: index.html');
	}
?>
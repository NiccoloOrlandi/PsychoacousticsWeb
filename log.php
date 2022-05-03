<?php
	include "config.php";
	//apro la sessione per comunicare con le altre pagine del sito
	session_start();

	//apro la connessione con il db
	$conn = new mysqli($host, $user, $password, $dbname);
	
	//controllo se è andata a buon fine
	if ($conn->errno){
		echo "Errore di connessione";
	    die("Problemi di connessione" . $conn->error);
	}
	echo "connessione eseguita";
	//uso codifica utf8 per comunicare col db
	mysqli_set_charset($conn, "utf8");
	
	//recupero username e password dal form di registrazione
   // $usr = $_POST['usr'];
	//	$psw = $_POST['psw'];
    
	//controllo se esiste
    //$sql = "SELECT Guest_ID FROM account WHERE username='$usr' AND password=SHA2('$psw', 256)";
	$sql = "SELECT * FROM account ";
    $result=$conn->query($sql);
	echo results->num_rows;
    /*if($result->num_rows>0){
		$row=$result->fetch_assoc();
		
		//faccio sapere alle altre pagine quale utente è loggato
    	$_SESSION['usr'] = $usr;
		$_SESSION['idGuest'] = $row['Guest_ID'];
		
		$conn->close();
		header('Location: index.html');
	}else{
		$conn->close();
		header('Location: login.php?err=1');
	}
	*/
?>

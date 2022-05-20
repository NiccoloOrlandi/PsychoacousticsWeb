<?php
	include "config.php";
	//apro la sessione per comunicare con le altre pagine del sito
	session_start();

	//apro la connessione con il db
	$conn = new mysqli($host, $user, $password, $dbname);
	
	//controllo se è andata a buon fine
	if ($conn->errno)
	    die("Problemi di connessione" . $conn->error);

	//uso codifica utf8 per comunicare col db
	mysqli_set_charset($conn, "utf8");
	
	//recupero username e password dal form di registrazione
    $usr = $_POST['usr'];
    
	//controllo se esiste già
    $sql = "SELECT * FROM account WHERE username='$usr'";
    $result=$conn->query($sql);
    if($result->num_rows>0)  
		header('Location: registrazione.php?err=1'); //errore 1: lo definisco come errore di username già esistente

	//se non esiste eseguo la registrazione
    else{
		//prendo tutti i dati
		$psw = $_POST['psw'];
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$date = $_POST['date'];
		$gender = strtoupper($_POST['gender']);
		$notes = $_POST['notes'];
		
		//trovo l'id massimo
		$sql = "SELECT MAX(id) as maxId FROM guest";
		$result=$conn->query($sql);
		$row=$result->fetch_assoc();
		
		//uso l'id massimo + 1
		$id = $row['maxId'] + 1;
		
		//inizio a creare la query inserendo i valori non NULL
		$sql = "INSERT INTO guest (ID, name";
		$sqlVal = " VALUES ('$id', '$name'";
		
		if($surname != ""){
			$sql .= ",surname";
			$sqlVal .= ",'$surname'";
		}
		
		if($gender != "NULL"){
			$sql .= ",gender";
			$sqlVal .= ",'$gender'";
		}
		
		if($notes != ""){
			$sql .= ",notes";
			$sqlVal .= ",'$notes'";
		}
		
		$sql .= ")";
		$sqlVal .= ")";
		
		//creo il guest
		$sql .= $sqlVal;
		$conn->query($sql);
		
		//creo e collego l'account, salvo l'hash della password con sha2-256, tipo di account 0 (base)
		$sql = "INSERT INTO account VALUES ('$usr', SHA2('$psw', 256), ";
		if($date != "")
			$sql .= ",$date ";
		else
			$sql .= ",NULL ";
		$sql .= "'$id', '0', '".base64_encode($usr)."', NULL, NULL)";
		$conn->query($sql);
		
		//faccio sapere alle altre pagine quale utente è loggato
    	$_SESSION['usr'] = $usr;
		$_SESSION['idGuest'] = $id;
    	
    	$conn->close();

    	header('Location: index.php');
	}

?>

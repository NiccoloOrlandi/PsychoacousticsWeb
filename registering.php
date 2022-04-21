<?php		//apro la sessione per comunicare con le altre pagine del sito
	session_start();	//apro la connessione con il db
	$conn = new mysqli("localhost", "test", "", "psychoacoustics_db");		//controllo se è andata a buon fine
	if ($conn->errno)
	    die("Problemi di connessione" . $conn->error);	//uso codifica utf8 per comunicare col db	mysqli_set_charset($conn, "utf8");
		//recupero username e password dal form di registrazione
    $usr = $_POST['usr'];
    	//controllo se esiste già
    $sql = "SELECT * FROM account WHERE username='$usr'";
    $result=$conn->query($sql);
    if($result->num_rows>0)  		header('Location: registrazione.php?err=1'); //errore 1: lo definisco come errore di username già esistente
	//se non esiste eseguo la registrazione
    else{		//prendo tutti i dati		$psw = $_POST['psw'];		$name = $_POST['name'];		$surname = $_POST['surname'];		$date = $_POST['date'];		$gender = $_POST['gender'];		$notes = $_POST['notes'];				//creo il guest		$sql = "INSERT INTO guest (name, surname, age, gender, notes) VALUES ('$name', '$surname', '22', '$gender', '$notes')";		$conn->query($sql);				//trovo il suo id		$sql = "SELECT MAX(id) as maxId FROM guest WHERE name='$name' AND surname = '$surname' AND age=22 AND gender='$gender' AND notes='$notes'";		$result=$conn->query($sql);		$row=$result->fetch_assoc();		$id = $row['maxId'];				//creo e collego l'account, salvo l'hash della password con sha2-256
		$sql = "INSERT INTO account VALUES ('$usr', SHA2('$psw', 256), '$id')";
    	$conn->query($sql);		//faccio sapere alle altre pagine quale utente è loggato
    	$_SESSION['usr'] = $usr;		$_SESSION['idGuest'] = $id;
    	
    	$conn->close();
    	header('Location: index.html');
	}
?>
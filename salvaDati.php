<?php
	include "config.php";
	session_start();
	if(isset($_SESSION['idGuest']) && isset($_GET['result']) && isset($_GET['timestamp']) && isset($_GET['type']) && ($_SESSION["checkSave"])
		&& isset($_GET['amp']) && isset($_GET['freq']) && isset($_GET['dur']) && isset($_GET['blocks']) && isset($_GET['delta'])
		&& isset($_GET['nAFC']) && isset($_GET['fact']) && isset($_GET['secFact']) && isset($_GET['rev']) && isset($_GET['secRev'])
		&& isset($_GET['threshold']) && isset($_GET['alg']) && isset($_GET['score']) && isset($_GET['saveSettings'])){
		
		if(isset($_SESSION["score"]))
			$_SESSION["score"] .= $_GET['score'].";";
		else
			$_SESSION["score"] = $_GET['score'].";";
		$_SESSION["results"] = $_GET['result'];
		$_SESSION["timestamp"] = $_GET['timestamp'];
		$_SESSION["type"] = $_GET['type'];
		$_SESSION["amp"] = $_GET['amp'];
		$_SESSION["freq"] = $_GET['freq'];
		$_SESSION["dur"] = $_GET['dur'];
		$_SESSION["blocks"] = $_GET['blocks'];
		$_SESSION["delta"] = $_GET['delta'];
		$_SESSION["nAFC"] = $_GET['nAFC'];
		$_SESSION["fact"] = $_GET['fact'];
		$_SESSION["secFact"] = $_GET['secFact'];
		$_SESSION["rev"] = $_GET['rev'];
		$_SESSION["secRev"] = $_GET['secRev'];
		$_SESSION["threshold"] = $_GET['threshold'];
		$_SESSION["alg"] = $_GET['alg'];
		
		//apro la connessione con il db
		$conn = new mysqli($host, $user, $password, $dbname);
		
		//controllo se è andata a buon fine
		if ($conn->errno)
			die("Problemi di connessione" . $conn->error);

		//uso codifica utf8 per comunicare col db
		mysqli_set_charset($conn, "utf8");
    
		//trova il tipo
		$type = "";
		if($_GET['type'] == "freq")
			$type = "PURE_TONE_FREQUENCY";
		else if($_GET['type'] == "amp")
			$type = "PURE_TONE_INTENSITY";
		else if($_GET['type'] == "dur")
			$type = "PURE_TONE_DURATION";
		
		//trova il numero di test effettuati fin'ora
		$sql = "SELECT Max(Test_count) as count FROM test WHERE Guest_ID='{$_SESSION['idGuest']}'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		
		//il test corrente è il numero di test già effettuati + 1
		$count = $row['count']+1;
		
		//trovo l'id a cui associare il test
		$id = $_SESSION['idGuest'];
		if(isset($_SESSION['idGuestTest']))
			$id = $_SESSION['idGuestTest'];
		
		//inserisci i dati del nuovo test
		$sql = "INSERT INTO test VALUES ('$id', '$count', '{$_GET['timestamp']}', ";
		$sql .= "'$type', '{$_GET['amp']}', '{$_GET['freq']}', '{$_GET['dur']}', '{$_GET['blocks']}', ";
		$sql .= "'{$_GET['delta']}', '{$_GET['nAFC']}', '{$_GET['fact']}', '{$_GET['rev']}', ";
		$sql .= "'{$_GET['secFact']}', '{$_GET['secRev']}', '{$_GET['threshold']}', '{$_GET['alg']}', '{$_GET['result']}')";
		$conn->query($sql);

		if($_GET['saveSettings']){
			$sql = "UPDATE account SET fk_guestTest = '$id', fk_testCount = '$count' WHERE username = '{$_SESSION['usr']}' ";
		}
	}
	header("Location: results.php");
?>
<?php
	session_start();
	
	if(isset($_SESSION['idGuest']) && isset($_GET['result']) && isset($_GET['timestamp']) && isset($_GET['type']) && isset($_GET['description'])){
		//apro la connessione con il db
		$conn = new mysqli("localhost", "test", "", "psychoacoustics_db");
		
		//exec('ssh -f -L 3307:147.162.143.132:3306 username sleep 10 > /dev/null');
		//$conn = new mysqli('147.162.143.132', 'root', '234kbnD3.23d', 'Psychoacoustics_DB', '3307');
		
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
		
		//inserisci i dati del nuovo test
		$sql = "INSERT INTO test(Timestamp, Type, Description, Result, Guest_ID, Test_count) VALUES ('{$_GET['timestamp']}','$type','{$_GET['description']}','{$_GET['result']}','{$_SESSION['idGuest']}', '$count')";
		$conn->query($sql);
	}
	header("Location: index.html");
?>
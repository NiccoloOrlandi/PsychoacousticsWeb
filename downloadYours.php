<?php
	function addMine($conn, $txt, $usr){
		//prendo i dati dei test collegati al guest dell'account
		$sql = "SELECT Guest.Name as name, Guest.Surname as surname, Guest.Gender as gender, 
				Test.Test_count as count, Test.Type as type, Test.Timestamp as time, Test.Amplitude as amp, Test.Frequency as freq, 
				Test.Duration as dur, Test.blocks as blocks, Test.nAFC as nafc, Test.Factor as fact, Test.Reversal as rev, Test.SecFactor as secfact, 
				Test.SecReversal as secrev, Test.Threshold as thr, Test.Algorithm as alg, Test.Result as results, Account.date as date 
				
				FROM account 
				INNER JOIN guest ON account.Guest_ID=guest.ID
				INNER JOIN test ON guest.ID=test.Guest_ID
				
				WHERE account.username='$usr'";
		$result = $conn->query($sql);
		
		//parte variabile e scrittura su file
		while($row = $result->fetch_assoc()){
			//valore della prima parte (quella fissa che va ripetuta)
			$age = date_diff(date_create($row['date']), date_create('now'))->y;
			$firstValues = $row["name"].";".$row["surname"].";".$age.";".$row["gender"].";".$row["count"].";".$row["type"].";";
			$firstValues .= $row["time"].";".$row["amp"].";".$row["freq"].";".$row["dur"].";".$row["blocks"].";".$row["nafc"].";";
			$firstValues .= $row["fact"].";".$row["rev"].";".$row["secfact"].";".$row["secrev"].";".$row["thr"].";".$row["alg"];
			
			$results = explode(",", $row["results"]);
			writeResults($txt, $firstValues, $results);
		}
	}
	
	function writeResults($txt, $firstValues, $results){
		//results sarà nella forma ["bl1;tr1;del1;var1;varpos1;but1;cor1;rev1", "bl2;tr2;...", ...]
		for($i = 0;$i<count($results)-1;$i++){
			fwrite($txt, $firstValues.";");
			fwrite($txt, $results[$i]);
			fwrite($txt, "\n");//vado all'altra linea
		}
	}

	//apro la connessione con la sessione e col db
	include "config.php";
	session_start();
	
	$conn = new mysqli($host, $user, $password, $dbname);
	if ($conn->errno)
			die("Problemi di connessione" . $conn->error);
	mysqli_set_charset($conn, "utf8");
	
	//prendo i dati del guest
	$usr = $_SESSION['usr'];
	$id = $_SESSION['idGuest'];
	
	//creo e apro il file csv
	$path = "yourResults.csv";
	$txt = fopen($path, "w") or die("Unable to open file!");
	
	//scrivo il nome delle colonne
	$line = "Name;Surname;Age;Gender;Test Count;Test Type;Timestamp;Amplitude;Frequency;Duration;n. of blocks;";
	$line .= "nAFC;First factor;First reversals;Second factor;Second reversals;reversal threshold;algorithm;";
	$line .= "block;trials;delta;variable;Variable Position;Pressed button;correct?;reversals\n";
	
	fwrite($txt, $line);
	
	//metto i dati dei test dell'utente, se vanno messi
	if(isset($_GET['all']) && $_GET['all']==1){
		addMine($conn, $txt, $usr);
		
		//aggiungo una riga vuota per separare
		fwrite($txt, "\n");
	}
	
	//metto i dati dei guest collegati
	$sql = "SELECT Guest.Name as name, Guest.Surname as surname, Guest.Age as age, Guest.Gender as gender, 
			Test.Test_count as count, Test.Type as type, Test.Timestamp as time, Test.Amplitude as amp, Test.Frequency as freq, 
			Test.Duration as dur, Test.blocks as blocks, Test.nAFC as nafc, Test.Factor as fact, Test.Reversal as rev, Test.SecFactor as secfact, 
			Test.SecReversal as secrev, Test.Threshold as thr, Test.Algorithm as alg, Test.Result as results
			
			FROM account 
			INNER JOIN guest ON account.Username=guest.fk_guest
			INNER JOIN test ON guest.ID=test.Guest_ID
			
			WHERE account.username='$usr'";
	$result = $conn->query($sql);

	while($row = $result->fetch_assoc()){
		//valore della prima parte (quella fissa che va ripetuta)
		$firstValues = $row["name"].";".$row["surname"].";".$row["age"].";".$row["gender"].";".$row["count"].";".$row["type"].";";
		$firstValues .= $row["time"].";".$row["amp"].";".$row["freq"].";".$row["dur"].";".$row["blocks"].";".$row["nafc"].";";
		$firstValues .= $row["fact"].";".$row["rev"].";".$row["secfact"].";".$row["secrev"].";".$row["thr"].";".$row["alg"];
			
		//parte variabile e scrittura su file
		$results = explode(",", $row["results"]);
		writeResults($txt, $firstValues, $results);
	}
	
	fclose($txt);
	//*scrittura su file (per disattivare togliere uno slash da questo commento)
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename='.basename($path));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($path));
	header("Content-Type: text/plain");
	readfile($path);
	//*/
	unlink($path);//elimino il file dal server

?>
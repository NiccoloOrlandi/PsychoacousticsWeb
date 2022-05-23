<?php
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
	
	//controllo di sicurezza
	$sql = "SELECT Type FROM account WHERE Guest_ID='$id' AND Username='$usr'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['Type'] == 1){
		
		//creo e apro il file csv
		$path = "allResults.csv";
		$txt = fopen($path, "w") or die("Unable to open file!");
		
		//scrivo il nome delle colonne
		$line = "Name;Surname;Age;Gender;Test Count;Test Type;Timestamp;Amplitude;Frequency;Duration;n. of blocks;";
		$line .= "nAFC;First factor;First reversals;Second factor;Second reversals;reversal threshold;algorithm;";
		$line .= "block;trials;delta;variable;Variable Position;Pressed button;correct?;reversals\n";
		
		fwrite($txt, $line);
		
		//metto i dati dei guest collegati
		$sql = "SELECT Guest.Name as name, Guest.Surname as surname, Guest.Age as age, Guest.Gender as gender, 
				Test.Test_count as count, Test.Type as type, Test.Timestamp as time, Test.Amplitude as amp, Test.Frequency as freq, 
				Test.Duration as dur, Test.blocks as blocks, Test.nAFC as nafc, Test.Factor as fact, Test.Reversal as rev, Test.SecFactor as secfact, 
				Test.SecReversal as secrev, Test.Threshold as thr, Test.Algorithm as alg, Test.Result as results, account.Date as date
				
				FROM guest
				INNER JOIN test ON guest.ID=test.Guest_ID
				LEFT JOIN account ON guest.ID=account.Guest_ID;";
		$result = $conn->query($sql);

		while($row = $result->fetch_assoc()){
			if($row['date']!="")
				$age = strval(date_diff(date_create($row['date']), date_create('now'))->y);
			else if(strval($row['age'])!='0')
				$age = strval($row['age']);
			else
				$age = "";
			
			//valore della prima parte (quella fissa che va ripetuta)
			$firstValues = $row["name"].";".$row["surname"].";".$age.";".$row["gender"].";".$row["count"].";".$row["type"].";";
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
	}
	else{//tentativo di accesso senza permessi: scrivo nel file log
		date_default_timezone_set('Europe/Rome');
		$date = date('Y/m/d h:i:s a', time());
		
		$txt = fopen("log.txt", "a") or die("Unable to open file!");
		
		fwrite($txt, "Tentativo di accesso a downloadAll.php senza permessi - timestamp: ".$date);
		if(isset($_SESSION['usr']))
			fwrite($txt, " - username: ".$_SESSION['usr']);
		fwrite($txt, "\n");
		
		fclose($txt);
		header("Location: index.php?err=1");
	}

?>
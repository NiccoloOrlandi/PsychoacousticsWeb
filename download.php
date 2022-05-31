<?php
	try{
		//apro la connessione con la sessione e col db
		include "config.php";
		session_start();
		
		if(!isset($_GET['format']) || ($_GET['format']!="complete" && $_GET['format']!="reduced"))
			header("Location: index.php");
		else{
			
			$conn = new mysqli($host, $user, $password, $dbname);
			if ($conn->connect_errno)
				throw new Exception('DB connection failed');
			mysqli_set_charset($conn, "utf8");
			
			//prendo i dati del guest
			$id = $_SESSION['idGuest'];
			if(isset($_SESSION['idGuestTest']))
				$id = $_SESSION['idGuestTest'];
			if(isset($_SESSION['name']))
				$sql = "SELECT name, surname, age, gender FROM guest WHERE ID='$id'";
			else
				$sql = "SELECT name, surname, gender, date FROM guest INNER JOIN account ON account.Guest_ID = guest.ID WHERE ID='$id'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			
			//se il test è stato fatto dal guest dell'account loggato, la sua età viene calcolata dalla data di nascita
			if(!isset($_SESSION['name']))
				$age = date_diff(date_create($row['date']), date_create('now'))->y;
			else
				$age = $row['age'];
			
			//creo e apro il file csv
			if($_GET['format']=="complete")
				$path = "results.csv";
			else
				$path = "reducedResults.csv";
			$txt = fopen($path, "w") or die("Unable to open file!");
			fwrite($txt, chr(0xEF).chr(0xBB).chr(0xBF)); //utf8 encoding
			
			//scrivo il nome delle colonne
			$line = "Name;Surname;Age;Gender;Test Type;Timestamp;Amplitude;Frequency;Duration;n. of blocks;nAFC;ISI;";
			$line .= "First factor;First reversals;Second factor;Second reversals;reversal threshold;algorithm;";
			if($_GET['format']=="complete")
				$line .= "block;trials;delta;variable;Variable Position;Pressed button;correct?;reversals\n";
			else
				$line .= "block;score\n";
				
			fwrite($txt, $line);
			
			//valore della prima parte (quella fissa che va ripetuta)
			$firstValues = $row["name"].";".$row["surname"].";".$age.";".$row["gender"].";".$_SESSION["type"].";".$_SESSION["time"].";";
			$firstValues .= $_SESSION["amp"].";".$_SESSION["freq"].";".$_SESSION["dur"].";".$_SESSION["blocks"].";".$_SESSION["nAFC"].";".$_SESSION["ISI"].";";
			$firstValues .= $_SESSION["fact"].";".$_SESSION["rev"].";".$_SESSION["secFact"].";".$_SESSION["secRev"].";".$_SESSION["thr"].";".$_SESSION["alg"];
			
			if($_GET['format']=="complete"){
				//parte variabile e scrittura su file
				$results = explode(",", $_SESSION["results"]);
				//results sarà nella forma ["bl1;tr1;del1;var1;varpos1;but1;cor1;rev1", "bl2;tr2;...", ...]
				for($i = 0;$i<count($results)-1;$i++){
					fwrite($txt, $firstValues.";");//scrivo i valori fissi
					fwrite($txt, $results[$i]);//scrivo i valori variabili
					fwrite($txt, "\n");//vado all'altra linea
				}
			}else{
				$results = explode(";", $_SESSION["score"]);
				for($i = 0;$i<count($results);$i++){
					fwrite($txt, $firstValues.";");//scrivo i valori fissi
					fwrite($txt, ($i+1).";");//scrivo il blocco
					fwrite($txt, $results[$i]);//scrivo lo score del blocco
					fwrite($txt, "\n");//vado all'altra linea
				}
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
	}catch(Exception $e){
		header("Location: index.php?err=db");
	}
?>
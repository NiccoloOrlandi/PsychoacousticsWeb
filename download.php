<?php
	//apro la connessione con la sessione e col db
	include "config.php";
	session_start();
	
	if(!isset($_GET['format']) || ($_GET['format']!="complete" && $_GET['format']!="reduced"))
		header("Location: index.php");
	else{
		
		$conn = new mysqli($host, $user, $password, $dbname);
		if ($conn->errno)
				die("Problemi di connessione" . $conn->error);
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
		
		//scrivo il nome delle colonne
		$line = "Name;Surname;Age;Gender;Test Type;Timestamp;Amplitude;Frequency;Duration;n. of blocks;nAFC;First factor;";
		$line .= "First reversals;Second factor;Second reversals;reversal threshold;algorithm;block;";
		if($_GET['format']=="complete")
			$line .= "trials;delta;variable;Variable Position;Pressed button;correct?;reversals\n";
		else
			$line .= "score\n";
			
		fwrite($txt, $line);
		
		//valore della prima parte (quella fissa che va ripetuta)
		$firstValues = [];
		array_push($firstValues,$row["name"]);
		array_push($firstValues,$row["surname"]);
		array_push($firstValues,$age);
		array_push($firstValues,$row["gender"]);
		array_push($firstValues,$_SESSION["type"]);
		array_push($firstValues,$_SESSION["timestamp"]);
		array_push($firstValues,$_SESSION["amp"]);
		array_push($firstValues,$_SESSION["freq"]);
		array_push($firstValues,$_SESSION["dur"]);
		array_push($firstValues,$_SESSION["blocks"]);
		array_push($firstValues,$_SESSION["nAFC"]);
		array_push($firstValues,$_SESSION["fact"]);
		array_push($firstValues,$_SESSION["rev"]);
		array_push($firstValues,$_SESSION["secFact"]);
		array_push($firstValues,$_SESSION["secRev"]);
		array_push($firstValues,$_SESSION["threshold"]);
		array_push($firstValues,$_SESSION["alg"]);
		
		echo $_SESSION["results"];
		
		if($_GET['format']=="complete"){
			//parte variabile e scrittura su file
			$results = substr($_SESSION["results"], strpos($_SESSION["results"], ";")+1); 
			//results sarà nella forma "bl1,tr1,del1,var1,but1,cor1,rev1;bl2,tr2,del2,var2,but2,cor2,rev2;..."
			$pos = 0;
			$variableValues = [0, 0, 0, 0, 0, 0, 0, 0]; //blocks, trials, delta, variable, Variable Position, Pressed button, correct?, reversals
			for($i = 0, $j=0;$i<strlen($results)-1;$i++){
				if($results[$i]==";"){//quando incontro un punto e virgola sono all'ultimo dato
					$variableValues[$j] = substr($results,$pos,$i-$pos);
					$pos = $i+1;
					
					foreach($firstValues as $elem)//scrivo i dati fissi
						fwrite($txt, $elem.";");
					foreach($variableValues as $elem)//scrivo i dati variabili
						fwrite($txt, $elem.";");
					fwrite($txt, "\n");//vado all'altra linea
					$j=0;
				}else{
					if($results[$i]==","){//quando trovo una virgola è finito il valore di un dato
						$variableValues[$j] = substr($results,$pos,$i-$pos);
						$pos = $i+1;
						$j++;
					}
				}
			}
		}else{
			$results = $_SESSION['score'];
			$pos = 0;
			$cont = 1;
			$score = "";
			for($i = 0;$i<strlen($results);$i++){
				if($results[$i]==";"){//quando incontro un punto e virgola sono a fine di un blocco
					foreach($firstValues as $elem)//scrivo i dati fissi
						fwrite($txt, $elem.";");
					
					fwrite($txt, $cont.";");//scrivo il blocco
					fwrite($txt, substr($results,$pos,$i-$pos).";");//scrivo lo score del blocco
					fwrite($txt, "\n");//vado all'altra linea
					
					$pos = $i+1;
					$cont += 1;
				}
			}
		}
		
		fclose($txt);
		/*scrittura su file (per disattivare togliere uno slash da questo commento)
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
?>
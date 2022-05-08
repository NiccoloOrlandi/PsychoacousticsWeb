<?php
	 include "config.php"; 
	//accesso alla sessione
	session_start();
	unset($_SESSION['idGuestTest']); //se c'erano stati altri guest temporanei, li elimino per evitare collisioni
	
	//connessione al db
	$conn = new mysqli($host, $user, $password, $dbname);
						
	if ($conn->errno){
		die("Problemi di connessione" . $conn->error);
	}	
	
	mysqli_set_charset($conn, "utf8");
	
	// trovo l'id massimo fin'ora (così creo un utente con ID_max+1)
	$sql="SELECT max(ID) as max FROM guest ";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	$id = $row["max"]+1;
	
	// vedo se andranno salvati i dati del test
	$checkSave = 0;
	if(isset($_POST["checkSave"]))
		$checkSave = 1;
	$_SESSION["checkSave"] = $checkSave;
	
	if($checkSave==0)
		header("Location: soundSettings.php?test=".$_GET["test"]);
	else{
		
		//scrivo la query di creazione del guest
		$sql="INSERT into guest VALUES ( '".$id."' , '" .$_POST["name"] ."',";
				
		if($_POST["surname"] == ""){
			$_SESSION["surname"] = null;
			$sql .= "NULL, ";
		}else{
			$_SESSION["surname"] = $_POST["surname"];
			$sql .= "'".$_SESSION["surname"]."', ";
		}
		
		if($_POST["age"] == ""){
			$_SESSION["age"] = null;
			$sql .= "NULL, ";
		}else{
			$_SESSION["age"] = $_POST["age"];
			$sql .= "'".$_SESSION["age"]."', ";
		}
		
		if(!isset($_POST["gender"])){
			$_SESSION["gender"] = null;
			$sql .= "NULL, ";
		}else{
			$_SESSION["gender"] = $_POST["gender"];
			$sql .= "'".$_SESSION["gender"]."', ";
		}
		
		if($_POST["notes"] == ""){
			$_SESSION["notes"] = null;
			$sql .= "NULL, ";
		}else{
			$_SESSION["notes"] = $_POST["notes"];
			$sql .= "'".$_SESSION["notes"]."', ";
		}
		
		
		if($_POST["name"]=="" && !isset($_SESSION["idGuest"])) //niente log in e nome mancante (errore)
			header("Location: demographicData.php?test=".$_GET["test"]."&err=1");
		
		else if (!isset($_SESSION["idGuest"])){ //niente log in ma c'è il nome (creo il guest)
			$_SESSION["name"] = $_POST["name"];
		
			if($_POST["ref"] == ""){
				$_SESSION["ref"] = null;
				$sql .= "NULL) ";
			}else{
				$_SESSION["ref"] = $_POST["ref"];
				
				$refSQL = "SELECT Username FROM account WHERE referral='{$_SESSION["ref"]}';";
				$result = $conn->query($refSQL);
				$row = $result->fetch_assoc();
				
				$sql .= "'".$row['Username']."') ";
			}

			$conn->query($sql);
			$_SESSION['idGuest']=$id;

			header("Location: soundSettings.php?test=".$_GET["test"]);
			
		}
		else{ //è stato fatto il log in
			if($_POST["name"]=="" && $_POST['ref']=="")//log in ma niente nome e niente referral, il test va collegato all'account che ha fatto il log in
				header("Location: soundSettings.php?test=".$_GET["test"]);
			else if($_POST["name"]!="" && $_POST['ref']==""){//log in e nome ma niente referral, va creato un nuovo guest e va collegato all'account che ha fatto il log in
				$_SESSION["name"] = $_POST["name"];
				
				$sql .= "'".$_SESSION['usr']."') ";
				echo $sql;
				$conn->query($sql);
				$_SESSION['idGuestTest']=$id;

				header("Location: soundSettings.php?test=".$_GET["test"]);
			}else if($_POST["name"]=="" && $_POST['ref']!="")//log in e referral ma niente nome, va lanciato un errore (nome obbligatorio col referral)
				header("Location: demographicData.php?test=".$_GET["test"]."&err=2");
			else if($_POST["name"]!="" && $_POST['ref']!=""){//log in, referral e nome, va creato un nuovo guest e va collegato all'account del referral
				$_SESSION["name"] = $_POST["name"];
				
				$_SESSION["ref"] = $_POST["ref"];
				
				$refSQL = "SELECT Username FROM account WHERE referral='{$_SESSION["ref"]}';";
				$result = $conn->query($refSQL);
				$row = $result->fetch_assoc();
				
				$sql .= "'".$row['Username']."') ";
				
				$conn->query($sql);
				$_SESSION['idGuestTest']=$id;

				header("Location: soundSettings.php?test=".$_GET["test"]);
			}
			
		}
	}

?>